<?php

namespace App\Http\Controllers\Accessories;

use App\Helpers\StorageHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\UploadFileRequest;
use App\Models\Actionlog;
use App\Models\Accessory;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use \Illuminate\Contracts\View\View;
use \Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Response;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\StreamedResponse;

class AccessoriesFilesController extends Controller
{
    /**
     * Validates and stores files associated with a accessory.
     *
     * @param UploadFileRequest $request
     * @param int $accessoryId
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v1.0]
     * @todo Switch to using the AssetFileRequest form request validator.
     */
    public function store(UploadFileRequest $request, $accessoryId = null) : RedirectResponse
    {

        if (config('app.lock_passwords')) {
            return redirect()->route('accessories.show', ['accessory'=>$accessoryId])->with('error', trans('general.feature_disabled'));
        }

        $accessory = Accessory::find($accessoryId);

        if (isset($accessory->id)) {
            $this->authorize('accessories.files', $accessory);

            if ($request->hasFile('file')) {
                if (! Storage::exists('private_uploads/accessories')) {
                    Storage::makeDirectory('private_uploads/accessories', 775);
                }

                foreach ($request->file('file') as $file) {

                    $file_name = $request->handleFile('private_uploads/accessories/', 'accessory-'.$accessory->id, $file);
                    //Log the upload to the log
                    $accessory->logUpload($file_name, e($request->input('notes')));
                }


                return redirect()->route('accessories.show', $accessory->id)->with('success', trans('general.file_upload_success'));

            }

            return redirect()->route('accessories.show', $accessory->id)->with('error', trans('general.no_files_uploaded'));
        }
        // Prepare the error message
        return redirect()->route('accessories.index')
            ->with('error', trans('general.file_does_not_exist'));
    }

    /**
     * Deletes the selected accessory file.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v1.0]
     * @param int $accessoryId
     * @param int $fileId
     */
    public function destroy($accessoryId = null, $fileId = null) : RedirectResponse
    {
        $accessory = Accessory::find($accessoryId);

        // the asset is valid
        if (isset($accessory->id)) {
            $this->authorize('update', $accessory);
            $log = Actionlog::find($fileId);

            // Remove the file if one exists
            if (Storage::exists('accessories/'.$log->filename)) {
                try {
                    Storage::delete('accessories/'.$log->filename);
                } catch (\Exception $e) {
                    Log::debug($e);
                }
            }

            $log->delete();

            return redirect()->back()
                ->with('success', trans('admin/hardware/message.deletefile.success'));
        }

        // Redirect to the licence management page
        return redirect()->route('accessories.index')->with('error', trans('general.file_does_not_exist'));
    }

    /**
     * Allows the selected file to be viewed.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v1.4]
     * @param int $accessoryId
     * @param int $fileId
     */
    public function show($accessoryId = null, $fileId = null, $download = true) : View | RedirectResponse | Response | BinaryFileResponse | StreamedResponse
    {

        Log::debug('Private filesystem is: '.config('filesystems.default'));
        $accessory = Accessory::find($accessoryId);



        // the accessory is valid
        if (isset($accessory->id)) {
            $this->authorize('view', $accessory);
            $this->authorize('accessories.files', $accessory);

            if (! $log = Actionlog::whereNotNull('filename')->where('item_id', $accessory->id)->find($fileId)) {
                return redirect()->route('accessories.index')->with('error',  trans('admin/users/message.log_record_not_found'));
            }

            $file = 'private_uploads/accessories/'.$log->filename;

            if (Storage::missing($file)) {
                Log::debug('FILE DOES NOT EXISTS for '.$file);
                Log::debug('URL should be '.Storage::url($file));

                return response('File '.$file.' ('.Storage::url($file).') not found on server', 404)
                    ->header('Content-Type', 'text/plain');
            } else {

                // Display the file inline
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

        return redirect()->route('accessories.index')->with('error', trans('general.file_does_not_exist', ['id' => $fileId]));
    }
}
