<?php

namespace App\Http\Controllers;

use App\Helpers\StorageHelper;
use App\Http\Requests\UploadFileRequest;
use App\Models\Actionlog;
use App\Models\AssetModel;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use \Symfony\Component\HttpFoundation\StreamedResponse;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class AssetModelsFilesController extends Controller
{
    /**
     * Upload a file to the server.
     *
     * @param UploadFileRequest $request
     * @param int $modelId
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     *@since [v1.0]
     * @author [A. Gianotto] [<snipe@snipe.net>]
     */
    public function store(UploadFileRequest $request, $modelId = null) : RedirectResponse
    {
        if (! $model = AssetModel::find($modelId)) {
            return redirect()->route('models.index')->with('error', trans('admin/hardware/message.does_not_exist'));
        }

        $this->authorize('update', $model);

        if ($request->hasFile('file')) {
            if (! Storage::exists('private_uploads/assetmodels')) {
                Storage::makeDirectory('private_uploads/assetmodels', 775);
            }

            foreach ($request->file('file') as $file) {

                $file_name = $request->handleFile('private_uploads/assetmodels/','model-'.$model->id,$file);

                $model->logUpload($file_name, $request->get('notes'));
            }

            return redirect()->back()->with('success', trans('general.file_upload_success'));
        }

        return redirect()->back()->with('error', trans('admin/hardware/message.upload.nofiles'));
    }

    /**
     * Check for permissions and display the file.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @param  int $modelId
     * @param  int $fileId
     * @since [v1.0]
     */
    public function show($modelId = null, $fileId = null) : StreamedResponse | Response | RedirectResponse | BinaryFileResponse
    {
        $model = AssetModel::find($modelId);
        // the asset is valid
        if (isset($model->id)) {
            $this->authorize('view', $model);

            if (! $log = Actionlog::find($fileId)) {
                return response('No matching record for that model/file', 500)
                    ->header('Content-Type', 'text/plain');
            }

            $file = 'private_uploads/assetmodels/'.$log->filename;

            if (! Storage::exists($file)) {
                return response('File '.$file.' not found on server', 404)
                    ->header('Content-Type', 'text/plain');
            }

            if (request('inline') == 'true') {

                $headers = [
                    'Content-Disposition' => 'inline',
                ];

                return Storage::download($file, $log->filename, $headers);
            }

            return StorageHelper::downloader($file);
        }
        // Prepare the error message
        $error = trans('admin/hardware/message.does_not_exist', ['id' => $fileId]);

        // Redirect to the hardware management page
        return redirect()->route('hardware.index')->with('error', $error);
    }

    /**
     * Delete the associated file
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @param  int $modelId
     * @param  int $fileId
     * @since [v1.0]
     */
    public function destroy($modelId = null, $fileId = null) : RedirectResponse
    {
        $model = AssetModel::find($modelId);
        $this->authorize('update', $model);
        $rel_path = 'private_uploads/assetmodels';

        // the asset is valid
        if (isset($model->id)) {
            $this->authorize('update', $model);
            $log = Actionlog::find($fileId);
            if ($log) {
                if (Storage::exists($rel_path.'/'.$log->filename)) {
                    Storage::delete($rel_path.'/'.$log->filename);
                }
                $log->delete();

                return redirect()->back()->with('success', trans('admin/hardware/message.deletefile.success'));
            }

            return redirect()->back()
                ->with('success', trans('admin/hardware/message.deletefile.success'));
        }

        // Redirect to the hardware management page
        return redirect()->route('hardware.index')->with('error', trans('admin/hardware/message.does_not_exist'));
    }
}
