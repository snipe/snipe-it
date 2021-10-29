<?php

namespace App\Http\Controllers\Licenses;

use App\Helpers\StorageHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\AssetFileRequest;
use App\Models\Actionlog;
use App\Models\License;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\JsonResponse;
use enshrined\svgSanitize\Sanitizer;

class LicenseFilesController extends Controller
{
    /**
     * Validates and stores files associated with a license.
     *
     * @todo Switch to using the AssetFileRequest form request validator.
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v1.0]
     * @param AssetFileRequest $request
     * @param int $licenseId
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(AssetFileRequest $request, $licenseId = null)
    {
        $license = License::find($licenseId);

        if (isset($license->id)) {
            $this->authorize('update', $license);

            if ($request->hasFile('file')) {
                if (! Storage::exists('private_uploads/licenses')) {
                    Storage::makeDirectory('private_uploads/licenses', 775);
                }

                foreach ($request->file('file') as $file) {

                    $extension = $file->getClientOriginalExtension();
                    $file_name = 'license-'.$license->id.'-'.str_random(8).'-'.str_slug(basename($file->getClientOriginalName(), '.'.$extension)).'.'.$extension;


                        // Check for SVG and sanitize it
                        if ($extension == 'svg') {
                            \Log::debug('This is an SVG');
                            \Log::debug($file_name);

                                $sanitizer = new Sanitizer();
                                $dirtySVG = file_get_contents($file->getRealPath());
                                $cleanSVG = $sanitizer->sanitize($dirtySVG);

                                try {
                                    Storage::put('private_uploads/licenses/'.$file_name, $cleanSVG);
                                } catch (\Exception $e) {
                                    \Log::debug('Upload no workie :( ');
                                    \Log::debug($e);
                                }

                        } else {
                            Storage::put('private_uploads/licenses/'.$file_name, file_get_contents($file));
                        }

                    //Log the upload to the log
                    $license->logUpload($file_name, e($request->input('notes')));
                }


                    return redirect()->route('licenses.show', $license->id)->with('success', trans('admin/licenses/message.upload.success'));

            }

            return redirect()->route('licenses.show', $license->id)->with('error', trans('admin/licenses/message.upload.nofiles'));
        }
        // Prepare the error message
        return redirect()->route('licenses.index')
            ->with('error', trans('admin/licenses/message.does_not_exist'));
    }

    /**
     * Deletes the selected license file.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v1.0]
     * @param int $licenseId
     * @param int $fileId
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy($licenseId = null, $fileId = null)
    {
        $license = License::find($licenseId);

        // the asset is valid
        if (isset($license->id)) {
            $this->authorize('update', $license);
            $log = Actionlog::find($fileId);

            // Remove the file if one exists
            if (Storage::exists('licenses/'.$log->filename)) {
                try {
                    Storage::delete('licenses/'.$log->filename);
                } catch (\Exception $e) {
                    \Log::debug($e);
                }
            }

            $log->delete();

            return redirect()->back()
                ->with('success', trans('admin/hardware/message.deletefile.success'));
        }

        // Redirect to the licence management page
        return redirect()->route('licenses.index')->with('error', trans('admin/licenses/message.does_not_exist'));
    }

    /**
     * Allows the selected file to be viewed.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v1.4]
     * @param int $licenseId
     * @param int $fileId
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function show($licenseId = null, $fileId = null, $download = true)
    {
        \Log::info('Private filesystem is: '.config('filesystems.default'));
        $license = License::find($licenseId);

        // the license is valid
        if (isset($license->id)) {
            $this->authorize('view', $license);

            if (! $log = Actionlog::find($fileId)) {
                return response('No matching record for that asset/file', 500)
                    ->header('Content-Type', 'text/plain');
            }

            $file = 'private_uploads/licenses/'.$log->filename;

            if (Storage::missing($file)) {
                \Log::debug('NOT EXISTS for '.$file);
                \Log::debug('NOT EXISTS URL should be '.Storage::url($file));

                return response('File '.$file.' ('.Storage::url($file).') not found on server', 404)
                    ->header('Content-Type', 'text/plain');
            } else {

                // We have to override the URL stuff here, since local defaults in Laravel's Flysystem
                // won't work, as they're not accessible via the web
                if (config('filesystems.default') == 'local') { // TODO - is there any way to fix this at the StorageHelper layer?
                    return StorageHelper::downloader($file);
                } else {
                    if ($download != 'true') {
                        \Log::debug('display the file');
                        if ($contents = file_get_contents(Storage::url($file))) { // TODO - this will fail on private S3 files or large public ones
                            return Response::make(Storage::url($file)->header('Content-Type', mime_content_type($file)));
                        }

                        return JsonResponse::create(['error' => 'Failed validation: '], 500);
                    }

                    return StorageHelper::downloader($file);

                }
            }
        }

        return redirect()->route('license.index')->with('error', trans('admin/licenses/message.does_not_exist', ['id' => $fileId]));
    }
}
