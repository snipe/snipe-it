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

            if ($log = Actionlog::whereNotNull('filename')->where('item_id', $license->id)->find($fileId)) {
                $file = 'private_uploads/licenses/'.$log->filename;

                try {
                    return StorageHelper::showOrDownloadFile($file, $log->filename);
                } catch (\Exception $e) {
                    return redirect()->route('licenses.show', ['licenses' => $license])->with('error',  trans('general.file_not_found'));
                }
            }

            // The log record doesn't exist somehow
            return redirect()->route('licenses.show', ['licenses' => $license])->with('error',  trans('general.log_record_not_found'));

        }

        return redirect()->route('licenses.index')->with('error', trans('admin/licenses/message.does_not_exist', ['id' => $fileId]));
    }
}
