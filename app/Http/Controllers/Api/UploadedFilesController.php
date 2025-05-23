<?php

namespace App\Http\Controllers\Api;

use App\Helpers\Helper;
use App\Helpers\StorageHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\UploadFileRequest;
use App\Http\Transformers\UploadedFilesTransformer;
use App\Models\Accessory;
use App\Models\Actionlog;
use App\Models\Asset;
use App\Models\AssetModel;
use App\Models\Component;
use App\Models\Consumable;
use App\Models\License;
use App\Models\Location;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\StreamedResponse;


class UploadedFilesController extends Controller
{


    static $map_object_type = [
        'accessories' => Accessory::class,
        'assets' => Asset::class,
        'components' => Component::class,
        'consumables' => Consumable::class,
        'locations' => Location::class,
        'models' => AssetModel::class,
        'users' => User::class,
    ];

    static $map_storage_path = [
        'accessories' => 'private_uploads/accessories/',
        'assets' => 'private_uploads/assets/',
        'components' => 'private_uploads/components/',
        'consumables' => 'private_uploads/consumables/',
        'locations' => 'private_uploads/locations/',
        'models' => 'private_uploads/assetmodels/',
        'users' => 'private_uploads/users/',
    ];

    static $map_file_prefix= [
        'accessories' => 'accessory',
        'assets' => 'asset',
        'components' => 'component',
        'consumables' => 'consumable',
        'locations' => 'location',
        'models' => 'model',
        'users' => 'user',
    ];




    /**
     * List the files for an object.
     *
     * @since [v7.0.12]
     * @author [r-xyz]
     */
    public function index(Request $request, $object_type, $id) : JsonResponse | array
    {

        $object = self::$map_object_type[$object_type]::find($id);
        $this->authorize('view', $object);

        if (!$object) {
            return response()->json(Helper::formatStandardApiResponse('error', null, trans('general.file_upload_status.invalid_object')));
        }

        // Columns allowed for sorting
        $allowed_columns =
            [
                'id',
                'filename',
                'action_type',
                'note',
                'created_at',
            ];

        $uploads = $object->uploads();
        $offset = ($request->input('offset') > $object->count()) ? $object->count() : abs($request->input('offset'));
        $limit = app('api_limit_value');
        $order = $request->input('order') === 'asc' ? 'asc' : 'desc';
        $sort = in_array($request->input('sort'), $allowed_columns) ? $request->input('sort') : 'action_logs.created_at';

        // Text search on action_logs fields
        // We could use the normal Actionlogs text scope, but it's a very heavy query since it's searcghing across all relations
        // And we generally won't need that here
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
     * Accepts a POST to upload a file to the server.
     *
     * @param \App\Http\Requests\UploadFileRequest $request
     * @param int $assetModelId
     * @since [v7.0.12]
     * @author [r-xyz]
     */
    public function store(UploadFileRequest $request, $object_type, $id) : JsonResponse
    {
        \Log::debug('store fired');

        $object = self::$map_object_type[$object_type]::find($id);
        $this->authorize('view', $object);

        if (!$object) {
            return response()->json(Helper::formatStandardApiResponse('error', null, trans('general.file_upload_status.invalid_object')));
        }

        // If the file storage directory doesn't exist, create it
        if (! Storage::exists(self::$map_storage_path[$object_type])) {
            Storage::makeDirectory(self::$map_storage_path[$object_type], 775);
        }


        if ($request->hasFile('file')) {
            // Loop over the attached files and add them to the object
            foreach ($request->file('file') as $file) {
                $file_name = $request->handleFile(self::$map_storage_path[$object_type],self::$map_file_prefix[$object_type].'-'.$object->id, $file);
                $files[] = $file_name;
                $object->logUpload($file_name, $request->get('notes'));
            }

            $files = Actionlog::select('action_logs.*')->where('action_type', '=', 'uploaded')
                ->where('item_type', '=', self::$map_object_type[$object_type])
                ->where('item_id', '=', $id)->whereIn('filename', $files)
                ->get();

            return response()->json(Helper::formatStandardApiResponse('success', (new UploadedFilesTransformer())->transformFiles($files, count($files)), trans_choice('general.file_upload_status.upload.success',  count($files))));
        }

        // No files were submitted
        return response()->json(Helper::formatStandardApiResponse('error', null, trans('general.file_upload_status.nofiles')));
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
    public function show($object_type, $id, $file_id) : JsonResponse | StreamedResponse | Storage | StorageHelper | BinaryFileResponse
    {
        $object = self::$map_object_type[$object_type]::find($id);
        $this->authorize('view', $object);

        if (!$object) {
            return response()->json(Helper::formatStandardApiResponse('error', null, trans('general.file_upload_status.invalid_object')));
        }


        // Check that the file being requested exists for the asset
        if (! $log = Actionlog::whereNotNull('filename')
            ->where('item_type', AssetModel::class)
            ->where('item_id', $object->id)->find($file_id)) {
            return response()->json(Helper::formatStandardApiResponse('error', null, trans('general.file_upload_status.invalid_id')), 404);
        }


        if (! Storage::exists(self::$map_storage_path[$object_type].'/'.$log->filename)) {
            return response()->json(Helper::formatStandardApiResponse('error', null, trans('general.file_upload_status.file_not_found'), 200));
        }

        if (request('inline') == 'true') {
            $headers = [
                'Content-Disposition' => 'inline',
            ];
            return Storage::download(self::$map_storage_path[$object_type].'/'.$log->filename, $log->filename, $headers);
        }

        return StorageHelper::downloader(self::$map_storage_path[$object_type].'/'.$log->filename);

    }

    /**
     * Delete the associated file
     *
     * @param  AssetModel $model
     * @param  int $fileId
     * @since [v7.0.12]
     * @author [r-xyz]
     */
    public function destroy($object_type, $id, $file_id) : JsonResponse
    {

        $object = self::$map_object_type[$object_type]::find($id);
        $this->authorize('update', $file_id);

        if (!$object) {
            return response()->json(Helper::formatStandardApiResponse('error', null, trans('general.file_upload_status.invalid_object')));
        }


        // Check for the file
        $log = Actionlog::find($file_id)->where('item_type', AssetModel::class)
            ->where('item_id', $object->id)->first();

        if ($log) {
            // Check the file actually exists, and delete it
            if (Storage::exists(self::$map_storage_path[$object_type].'/'.$log->filename)) {
                Storage::delete(self::$map_storage_path[$object_type].'/'.$log->filename);
            }
            // Delete the record of the file
            if ($log->delete()) {
                return response()->json(Helper::formatStandardApiResponse('success', null, trans_choice('general.file_upload_status.delete.success', 1)), 200);
            }


        }

        // The file doesn't seem to really exist, so report an error
        return response()->json(Helper::formatStandardApiResponse('error', null, trans_choice('general.file_upload_status.delete.error', 1)), 500);

    }
}
