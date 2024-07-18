<?php

namespace App\Http\Controllers\Licenses;

use App\Helpers\StorageHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\UploadFileRequest;
use App\Models\Actionlog;
use App\Models\License;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class LicenseFilesController extends Controller
{
    /**
     * Validates and stores files associated with a license.
     *
     * @param UploadFileRequest $request
     * @param int $licenseId
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v1.0]
     * @todo Switch to using the AssetFileRequest form request validator.
     */
    public function store(UploadFileRequest $request, $licenseId = null)
    {
        $license = License::find($licenseId);

        if (isset($license->id)) {
            $this->authorize('update', $license);

            if ($request->hasFile('file')) {
                if (! Storage::exists('private_uploads/licenses')) {
                    Storage::makeDirectory('private_uploads/licenses', 775);
                }

                foreach ($request->file('file') as $file) {
                    $file_name = $request->handleFile('private_uploads/licenses/','license-'.$license->id, $file);

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
        if ($license = License::find($licenseId)) {

            $this->authorize('update', $license);

            if ($log = Actionlog::find($fileId)) {

                // Remove the file if one exists
                if (Storage::exists('licenses/'.$log->filename)) {
                    try {
                        Storage::delete('licenses/'.$log->filename);
                    } catch (\Exception $e) {
                        Log::debug($e);
                    }
                }
                
                $log->delete();

                return redirect()->back()
                    ->with('success', trans('admin/hardware/message.deletefile.success'));
            }

            return redirect()->route('licenses.index')->with('error', trans('general.log_does_not_exist'));
        }

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
        $license = License::find($licenseId);

        // the license is valid
        if (isset($license->id)) {
            $this->authorize('view', $license);
            $this->authorize('licenses.files', $license);

            if (! $log = Actionlog::whereNotNull('filename')->where('item_id', $license->id)->find($fileId)) {
                return response('No matching record for that asset/file', 500)
                    ->header('Content-Type', 'text/plain');
            }

            $file = 'private_uploads/licenses/'.$log->filename;

            if (Storage::missing($file)) {
                Log::debug('NOT EXISTS for '.$file);
                Log::debug('NOT EXISTS URL should be '.Storage::url($file));

                return response('File '.$file.' ('.Storage::url($file).') not found on server', 404)
                    ->header('Content-Type', 'text/plain');
            } else {

                if (request('inline') == 'true') {

                    $headers = [
                        'Content-Disposition' => 'inline',
                    ];

                    return Storage::download($file, $log->filename, $headers);
                }

                // We have to override the URL stuff here, since local defaults in Laravel's Flysystem
                // won't work, as they're not accessible via the web
                if (config('filesystems.default') == 'local') { // TODO - is there any way to fix this at the StorageHelper layer?
                    return StorageHelper::downloader($file);

                }
            }
        }

        return redirect()->route('licenses.index')->with('error', trans('admin/licenses/message.does_not_exist', ['id' => $fileId]));
    }
}
