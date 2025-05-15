<?php

namespace App\Http\Controllers\Api;

use App\Helpers\StorageHelper;
use App\Http\Transformers\UploadedFilesTransformer;
use App\Models\Asset;
use Illuminate\Support\Facades\Storage;
use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Models\AssetModel;
use App\Models\Actionlog;
use App\Http\Requests\UploadFileRequest;
use App\Http\Transformers\AssetModelsTransformer;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Illuminate\Http\Request;

/**
 * This class controls file related actions related
 * to assets for the Snipe-IT Asset Management application.
 *
 * Based on the Assets/AssetFilesController by A. Gianotto <snipe@snipe.net>
 *
 * @version    v1.0
 * @author [T. Scarsbrook] [<snipe@scarzybrook.co.uk>]
 */
class AssetModelFilesController extends Controller
{
    /**
     * Accepts a POST to upload a file to the server.
     *
     * @param \App\Http\Requests\UploadFileRequest $request
     * @param int $assetModelId
     * @since [v7.0.12]
     * @author [r-xyz]
     */
    public function store(UploadFileRequest $request, AssetModel $model) : JsonResponse
    {

        $this->authorize('update', $model);

        if ($request->hasFile('file')) {
        // If the file storage directory doesn't exist, create it
        if (! Storage::exists('private_uploads/assetmodels')) {
            Storage::makeDirectory('private_uploads/assetmodels', 775);
        }

        // Loop over the attached files and add them to the asset
        foreach ($request->file('file') as $file) {
            $file_name = $request->handleFile('private_uploads/assetmodels/','model-'.$model->id, $file);
            $files[] = $file_name;
            $model->logUpload($file_name, $request->get('notes'));
            \Log::error($file_name);
        }
            $files = Actionlog::select('action_logs.*')->where('action_type', '=', 'uploaded')
                ->where('item_type', '=', AssetModel::class)
                ->where('item_id', '=', $model->id)->whereIn('filename', $files)
                ->get();

            return response()->json(Helper::formatStandardApiResponse('success', (new UploadedFilesTransformer())->transformFiles($files, count($files)), trans('admin/hardware/message.upload.success')));
        }

        // No files were submitted
        return response()->json(Helper::formatStandardApiResponse('error', null, trans('admin/models/message.upload.nofiles')), 500);
    }

    /**
     * List the files for an asset.
     *
     * @param  AssetModel $model
     * @since [v7.0.12]
     * @author [r-xyz]
     */
    public function list(Request $request, AssetModel $model) : JsonResponse | array
    {
        $this->authorize('view', $model);

        $allowed_columns =
            [
                'id',
                'filename',
                'action_type',
                'note',
                'created_at',
            ];

        $uploads = $model->uploads();
        $offset = ($request->input('offset') > $model->count()) ? $model->count() : abs($request->input('offset'));
        $limit = app('api_limit_value');
        $order = $request->input('order') === 'asc' ? 'asc' : 'desc';
        $sort = in_array($request->input('sort'), $allowed_columns) ? $request->input('sort') : 'action_logs.created_at';

        if ($request->filled('search')) {

            $uploads->where(function ($query) use ($request) {
                $query->where('filename', 'LIKE', '%' . $request->input('search') . '%')
                    ->orWhere('note', 'LIKE', '%' . $request->input('search') . '%');
            });
        }

        $uploads = $uploads->skip($offset)->take($limit)->orderBy($sort, $order)->get();


        return (new UploadedFilesTransformer())->transformFiles($uploads, $uploads->count());
    }

    /**
     * Check for permissions and display the file.
     *
     * @param  AssetModel $model
     * @param  int $fileId
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @since [v7.0.12]
     * @author [r-xyz]
     */
    public function show(AssetModel $model, $file_id = null) : JsonResponse | StreamedResponse | Storage | StorageHelper | BinaryFileResponse
    {

        $this->authorize('view', $model);

        // Check that the file being requested exists for the asset
        if (! $log = Actionlog::whereNotNull('filename')->where('item_id', $model->id)->find($file_id)) {
            return response()->json(Helper::formatStandardApiResponse('error', null, trans('admin/models/message.download.no_match', ['id' => $file_id])), 404);
        }

        // Form the full filename with path
        $file = 'private_uploads/assetmodels/'.$log->filename;
        Log::debug('Checking for '.$file);


        // Check the file actually exists on the filesystem
        if (! Storage::exists($file)) {
            return response()->json(Helper::formatStandardApiResponse('error', null, trans('admin/models/message.download.does_not_exist', ['id' => $file_id])), 404);
        }

        if (request('inline') == 'true') {

            $headers = [
                'Content-Disposition' => 'inline',
            ];

            return Storage::download($file, $log->filename, $headers);
        }

        return StorageHelper::downloader($file);
        // Send back an error message

        //@TODO: respond if file doesn't exist
        return response()->json(Helper::formatStandardApiResponse('error', null, trans('admin/models/message.download.error', ['id' => $file_id])), 500);
    }

    /**
     * Delete the associated file
     *
     * @param  AssetModel $model
     * @param  int $fileId
     * @since [v7.0.12]
     * @author [r-xyz]
     */
    public function destroy(AssetModel $model, $fileId = null) : JsonResponse
    {
        $rel_path = 'private_uploads/assetmodels';

        // the asset is valid
        if (isset($model->id)) {
            $this->authorize('update', $model);

            // Check for the file
            $log = Actionlog::find($fileId);
            if ($log) {
                // Check the file actually exists, and delete it
                if (Storage::exists($rel_path.'/'.$log->filename)) {
                    Storage::delete($rel_path.'/'.$log->filename);
                }
                // Delete the record of the file
                $log->delete();

                // All deleting done - notify the user of success
                return response()->json(Helper::formatStandardApiResponse('success', null, trans('admin/models/message.deletefile.success')), 200);
            }

            // The file doesn't seem to really exist, so report an error
            return response()->json(Helper::formatStandardApiResponse('error', null, trans('admin/models/message.deletefile.error')), 500);
        }

        return response()->json(Helper::formatStandardApiResponse('error', null, trans('admin/models/message.deletefile.error')), 500);
    }
}
