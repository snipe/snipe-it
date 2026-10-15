<?php

namespace Tests\Feature\Uploads;

use App\Http\Traits\ConvertsBase64ToFiles;
use Illuminate\Foundation\Http\FormRequest;
use Tests\TestCase;

class Base64TempFileLeakTest extends TestCase
{
    public function test_invalid_base64_input_does_not_create_a_tempfile(): void
    {
        $prefix = 'snipeleak_'.bin2hex(random_bytes(6));

        $request = Base64LeakProbeRequest::make($prefix, 'not-a-data-uri');
        $request->triggerPrepareForValidation();

        $leftovers = glob(sys_get_temp_dir().'/'.$prefix.'*');
        $this->assertEmpty(
            $leftovers,
            'Invalid base64 input must not create a tempfile. Leftovers: '.implode(', ', $leftovers ?: []),
        );
    }

    public function test_empty_input_does_not_create_a_tempfile(): void
    {
        // Early-return path: no base64 value in the field at all. This
        // already short-circuited pre-fix, but the test documents the
        // intended behavior now that the invalid-string path matches.
        $prefix = 'snipeleak_'.bin2hex(random_bytes(6));

        $request = Base64LeakProbeRequest::make($prefix, '');
        $request->triggerPrepareForValidation();

        $leftovers = glob(sys_get_temp_dir().'/'.$prefix.'*');
        $this->assertEmpty(
            $leftovers,
            'Empty input must not create a tempfile. Leftovers: '.implode(', ', $leftovers ?: []),
        );
    }

    public function test_valid_data_uri_still_produces_a_tempfile_backed_upload(): void
    {
        // Companion: the reorder must not have broken the happy path.
        // A real data URI should still land as a tempfile wrapped in an
        // UploadedFile on the request. The register_shutdown_function
        // cleanup for this file fires at PHP shutdown, which happens
        // after this test method returns, so we only assert that the
        // tempfile exists while the request is live.
        $prefix = 'snipeleak_'.bin2hex(random_bytes(6));
        $dataUri = 'data:text/plain;base64,'.base64_encode('hello');

        $request = Base64LeakProbeRequest::make($prefix, $dataUri);
        $request->triggerPrepareForValidation();

        $leftovers = glob(sys_get_temp_dir().'/'.$prefix.'*');
        $this->assertCount(
            1,
            $leftovers,
            'Valid base64 input must still produce exactly one tempfile for the UploadedFile to wrap.',
        );

        // Clean up this test's own artifact so repeated runs do not pile
        // up before the real shutdown handler fires at process end.
        @unlink($leftovers[0]);
    }
}

/**
 * Minimal FormRequest that uses the trait so the test can drive
 * prepareForValidation directly without routing through a real
 * controller. The trait method is protected, so we expose a public
 * trigger here.
 */
class Base64LeakProbeRequest extends FormRequest
{
    use ConvertsBase64ToFiles;

    private string $filePrefix = 'probe';

    public static function make(string $prefix, string $value): self
    {
        $request = self::create('/probe', 'POST', ['probe' => $value]);
        $request->filePrefix = $prefix;

        return $request;
    }

    public function triggerPrepareForValidation(): void
    {
        $this->prepareForValidation();
    }

    protected function base64FileKeys(): array
    {
        return ['probe' => $this->filePrefix];
    }
}
