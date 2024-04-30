<?php

namespace App\Http\Controllers\Api;

use App\Helpers\StorageHelper;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Gate;
use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Models\Asset;
use App\Models\AssetModel;
use App\Models\Actionlog;
use \Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;
use App\Http\Requests\UploadFileRequest;
use Illuminate\Support\Facades\Log;
use Input;
use Paginator;
use Slack;
use Str;
use TCPDF;
use Validator;
use Route;


/**
 * This class controls all actions related to assets for
 * the Snipe-IT Asset Management application.
 *
 * @version    v1.0
 * @author [A. Gianotto] [<snipe@snipe.net>]
 */
class AssetFilesController extends Controller
{
    /**
     * Accepts a POST to upload a file to the server.
     *
     * @param \App\Http\Requests\UploadFileRequest $request
     * @param int $assetId
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @since [v6.0]
     * @author [T. Scarsbrook] [<snipe@scarzybrook.co.uk>]
     */
    public function store(UploadFileRequest $request, $assetId = null)
    {
        if (! $asset = Asset::find($assetId)) {
            return response()->json(Helper::formatStandardApiResponse('error', null, trans('admin/hardware/message.does_not_exist')), 500);
        }

        $this->authorize('update', $asset);

        if ($request->hasFile('file')) {
            if (! Storage::exists('private_uploads/assets')) {
                Storage::makeDirectory('private_uploads/assets', 775);
            }

            foreach ($request->file('file') as $file) {
                $file_name = $request->handleFile('private_uploads/assets/','hardware-'.$asset->id, $file);
                
                $asset->logUpload($file_name, e($request->get('notes')));
            }

            return response()->json(Helper::formatStandardApiResponse('success', $asset, trans('admin/hardware/message.upload.success')));
        }

        return response()->json(Helper::formatStandardApiResponse('error', null, "Bad bananas"), 500);
        return response()->json(Helper::formatStandardApiResponse('error', null, trans('admin/hardware/message.upload.nofiles')), 500);
    }

    /**
     * List the files for an asset.
     *
     * @param  int $assetId
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @since [v6.0]
     * @author [T. Scarsbrook] [<snipe@scarzybrook.co.uk>]
     */
    public function list($assetId = null)
    {
        $asset = Asset::find($assetId);
	
	// the asset is valid
        if (isset($asset->id)) {
            $this->authorize('view', $asset);

            if ($asset->uploads->count() > 0) {
                $files = array();
                foreach ($asset->uploads as $upload) {
                    array_push($files, $upload);
                }
                return response()->json(Helper::formatStandardApiResponse('success', $files, trans('admin/hardware/message.upload.success')));
            }
            
            return response()->json(Helper::formatStandardApiResponse('error', null, trans('admin/hardware/message.download.no_match', ['id' => $fileId])), 500);
        }

        // Send back an error message
        return response()->json(Helper::formatStandardApiResponse('error', null, trans('admin/hardware/message.download.error', ['id' => $fileId])), 500);
    }

    /**
     * Check for permissions and display the file.
     *
     * @param  int $assetId
     * @param  int $fileId
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @since [v6.0]
     * @author [T. Scarsbrook] [<snipe@scarzybrook.co.uk>]
     */
    public function show($assetId = null, $fileId = null)
    {
        $asset = Asset::find($assetId);
        // the asset is valid
        if (isset($asset->id)) {
            $this->authorize('view', $asset);

            if (! $log = Actionlog::whereNotNull('filename')->where('item_id', $asset->id)->find($fileId)) {
                return response()->json(Helper::formatStandardApiResponse('error', null, trans('admin/hardware/message.download.no_match', ['id' => $fileId])), 500);
            }

            $file = 'private_uploads/assets/'.$log->filename;
            \Log::debug('Checking for '.$file);

            if ($log->action_type == 'audit') {
                $file = 'private_uploads/audits/'.$log->filename;
            }

            if (! Storage::exists($file)) {
                return response()->json(Helper::formatStandardApiResponse('error', null, trans('admin/hardware/message.download.does_not_exist', ['id' => $fileId])), 404);
            }

            if (request('inline') == 'true') {

                $headers = [
                    'Content-Disposition' => 'inline',
                ];

                return Storage::download($file, $log->filename, $headers);
            }

            return StorageHelper::downloader($file);
        }

        // Send back an error message
        return response()->json(Helper::formatStandardApiResponse('error', null, trans('admin/hardware/message.download.error', ['id' => $fileId])), 500);
    }

    /**
     * Delete the associated file
     *
     * @param  int $assetId
     * @param  int $fileId
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @since [v6.0]
     * @author [T. Scarsbrook] [<snipe@scarzybrook.co.uk>]
     */
    public function destroy($assetId = null, $fileId = null)
    {
        $asset = Asset::find($assetId);
        $this->authorize('update', $asset);
        $rel_path = 'private_uploads/assets';

        // the asset is valid
        if (isset($asset->id)) {
            $this->authorize('update', $asset);
            $log = Actionlog::find($fileId);
            if ($log) {
                if (Storage::exists($rel_path.'/'.$log->filename)) {
                    Storage::delete($rel_path.'/'.$log->filename);
                }
                $log->delete();

                return redirect()->back()->with('success', trans('admin/hardware/message.deletefile.success'));
            }

            return redirect()->back()->with('success', trans('admin/hardware/message.deletefile.success'));
        }

        // Redirect to the hardware management page
        return response()->json(Helper::formatStandardApiResponse('error', null, trans('admin/hardware/message.deletefile.error')), 500);
    }
}
