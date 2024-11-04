<?php

namespace App\Http\Controllers\Consumables;

use App\Helpers\StorageHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\UploadFileRequest;
use App\Models\Actionlog;
use App\Models\Consumable;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use Symfony\Consumable\HttpFoundation\JsonResponse;
use Illuminate\Support\Facades\Log;
class ConsumablesFilesController extends Controller
{
    /**
     * Validates and stores files associated with a consumable.
     *
     * @param UploadFileRequest $request
     * @param int $consumableId
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     *@author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v1.0]
     * @todo Switch to using the AssetFileRequest form request validator.
     */
    public function store(UploadFileRequest $request, $consumableId = null)
    {
        if (config('app.lock_passwords')) {
            return redirect()->route('consumables.show', ['consumable'=>$consumableId])->with('error', trans('general.feature_disabled'));
        }

        $consumable = Consumable::find($consumableId);

        if (isset($consumable->id)) {
            $this->authorize('update', $consumable);

            if ($request->hasFile('file')) {
                if (! Storage::exists('private_uploads/consumables')) {
                    Storage::makeDirectory('private_uploads/consumables', 775);
                }

                foreach ($request->file('file') as $file) {
                    $file_name = $request->handleFile('private_uploads/consumables/','consumable-'.$consumable->id, $file);

                    //Log the upload to the log
                    $consumable->logUpload($file_name, e($request->input('notes')));
                }


                return redirect()->route('consumables.show', $consumable->id)->with('success', trans('general.file_upload_success'));

            }

            return redirect()->route('consumables.show', $consumable->id)->with('error', trans('general.no_files_uploaded'));
        }
        // Prepare the error message
        return redirect()->route('consumables.index')
            ->with('error', trans('general.file_does_not_exist'));
    }

    /**
     * Deletes the selected consumable file.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v1.0]
     * @param int $consumableId
     * @param int $fileId
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy($consumableId = null, $fileId = null)
    {
        $consumable = Consumable::find($consumableId);

        // the asset is valid
        if (isset($consumable->id)) {
            $this->authorize('update', $consumable);
            $log = Actionlog::find($fileId);

            // Remove the file if one exists
            if (Storage::exists('consumables/'.$log->filename)) {
                try {
                    Storage::delete('consumables/'.$log->filename);
                } catch (\Exception $e) {
                    Log::debug($e);
                }
            }

            $log->delete();

            return redirect()->back()
                ->with('success', trans('admin/hardware/message.deletefile.success'));
        }

        // Redirect to the licence management page
        return redirect()->route('consumables.index')->with('error', trans('general.file_does_not_exist'));
    }

    /**
     * Allows the selected file to be viewed.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v1.4]
     * @param int $consumableId
     * @param int $fileId
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function show($consumableId = null, $fileId = null)
    {
        $consumable = Consumable::find($consumableId);

        // the consumable is valid
        if (isset($consumable->id)) {
            $this->authorize('view', $consumable);
            $this->authorize('consumables.files', $consumable);

            if ($log = Actionlog::whereNotNull('filename')->where('item_id', $consumable->id)->find($fileId)) {
                $file = 'private_uploads/consumables/'.$log->filename;

                try {
                    return StorageHelper::showOrDownloadFile($file, $log->filename);
                } catch (\Exception $e) {
                    return redirect()->route('consumables.show', ['consumable' => $consumable])->with('error',  trans('general.file_not_found'));
                }
            }
            // The log record doesn't exist somehow
            return redirect()->route('consumables.show', ['consumable' => $consumable])->with('error',  trans('general.log_record_not_found'));

        }

        return redirect()->route('consumables.index')->with('error', trans('general.file_does_not_exist', ['id' => $fileId]));
    }
}
