<?php

namespace App\Http\Controllers\Assets;

use App\Http\Controllers\Controller;
use App\Http\Requests\FileAttachmentRequest;
use App\Models\Actionlog;
use App\Models\Asset;
use App\Models\Traits\Attachable;
use Illuminate\Http\RedirectResponse;

class AssetFilesController extends Controller
{
    use Attachable;

    /**
     * Upload a file to the server.
     *
     * @param FileAttachmentRequest $request
     * @param int|null $assetId
     * @return RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     *@since [v1.0]
     * @author [A. Gianotto] [<snipe@snipe.net>]
     */
    public function store(FileAttachmentRequest $request, int $assetId = null)
    {
        if (!$asset = Asset::find($assetId)) {
            return redirect()->route('hardware.index')->with('error', trans('admin/hardware/message.does_not_exist'));
        }

        $this->authorize('update', $asset);
        $asset->storeFiles($request->file('file'), $request->get('notes'));
        return redirect()->back()->with('success', trans('admin/hardware/message.upload.success'));
    }

    /**
     * Check for permissions and display the file.
     *
     * @param  int|null $assetId
     * @param int|null $fileId
     * @return \Illuminate\Contracts\Routing\ResponseFactory|RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     *@author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v1.0]
     */
    public function show(int $assetId = null, int $fileId = null, $download = true)
    {
        if (!$asset = Asset::find($assetId)) {
            // Redirect to the hardware management page
            return redirect()->route('hardware.index')->with('error',
                trans('admin/hardware/message.does_not_exist', ['id' => $fileId]));
        }
        $this->authorize('view', $asset);

        if (!$log = Actionlog::find($fileId)) {
            return response('No matching record for that asset/file', 500)
                ->header('Content-Type', 'text/plain');
        }
        return $asset->showFile($log->filename);
    }

    /**
     * Delete the associated file
     *
     * @param int|null $assetId
     * @param int|null $fileId
     * @return RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v1.0]
     */
    public function destroy(int $assetId = null, int $fileId = null)
    {
        if (!$asset = Asset::find($assetId)) {
            // Redirect to the hardware management page
            return redirect()->route('hardware.index')->with('error', trans('admin/hardware/message.does_not_exist'));
        }

        $this->authorize('update', $asset);
        if ($log = Actionlog::find($fileId)) {
            $asset->destroyFile($log);
        }
        return redirect()->back()->with('success', trans('admin/hardware/message.deletefile.success'));
    }
}