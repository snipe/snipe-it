<?php

namespace App\Http\Controllers\Assets;


use App\Http\Controllers\Controller;
use App\Http\Requests\AssetFileRequest;
use App\Models\Actionlog;
use App\Models\Asset;
use Carbon\Carbon;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;

class AssetFilesController extends Controller
{
    /**
     * Upload a file to the server.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @param AssetFileRequest $request
     * @param int $assetId
     * @return Redirect
     * @since [v1.0]
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(AssetFileRequest $request, $assetId = null)
    {
        if (!$asset = Asset::find($assetId)) {
            return redirect()->route('hardware.index')->with('error', trans('admin/hardware/message.does_not_exist'));
        }

        $this->authorize('update', $asset);

        if ($request->hasFile('file')) {

            if (!Storage::exists('private_uploads/assets')) Storage::makeDirectory('private_uploads/assets', 775);

            foreach ($request->file('file') as $file) {
                $extension = $file->getClientOriginalExtension();
                $file_name = 'hardware-'.$asset->id.'-'.str_random(8).'-'.str_slug(basename($file->getClientOriginalName(), '.'.$extension)).'.'.$extension;
                Storage::put('private_uploads/assets/'.$file_name, file_get_contents($file));
                $asset->logUpload($file_name, e($request->get('notes')));
            }
            return redirect()->back()->with('success', trans('admin/hardware/message.upload.success'));
        }

        return redirect()->back()->with('error', trans('admin/hardware/message.upload.nofiles'));
    }

    /**
     * Check for permissions and display the file.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @param  int $assetId
     * @param  int $fileId
     * @since [v1.0]
     * @return View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function show($assetId = null, $fileId = null, $download = true)
    {
        $asset = Asset::find($assetId);
        // the asset is valid
        if (isset($asset->id)) {
            $this->authorize('view', $asset);

            if (!$log = Actionlog::find($fileId)) {
                return response('No matching record for that asset/file', 500)
                    ->header('Content-Type', 'text/plain');
            }

            $filepath = 'private_uploads/assets/'.$log->filename;

            if ($log->action_type =='audit') {
                $filepath = 'private_uploads/audits/'.$log->filename;
            }


            $file = Storage::get($filepath);
            //$file = Storage::temporaryUrl($filepath, Carbon::now()->addMinutes(5));

            // Display the file, not download
            if ($download != 'true') {

                return response(Storage::get($filepath), 200)
                    ->header('Content-Type',  Storage::mimeType($filepath))
                    ->header('Content-Disposition', 'inline');

            }
            return Storage::download($filepath);
        }

        return redirect()->route('hardware.index')->with('error', trans('admin/hardware/message.does_not_exist', ['id' => $fileId]));
    }

    /**
     * Delete the associated file
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @param  int $assetId
     * @param  int $fileId
     * @since [v1.0]
     * @return View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy($assetId = null, $fileId = null)
    {
        $asset = Asset::find($assetId);
        $this->authorize('update', $asset);
        $rel_path = 'storage/private_uploads/assets';

        // the asset is valid
        if (isset($asset->id)) {
            $this->authorize('update', $asset);
            $log = Actionlog::find($fileId);
            if ($log) {
            if (file_exists(base_path().'/'.$rel_path.'/'.$log->filename)) {
                Storage::delete($rel_path.'/'.$log->filename);
                }
                $log->delete();
                return redirect()->back()->with('success', trans('admin/hardware/message.deletefile.success'));
            }
            $log->delete();
            return redirect()->back()
                ->with('success', trans('admin/hardware/message.deletefile.success'));
        }

        // Redirect to the hardware management page
        return redirect()->route('hardware.index')->with('error', trans('admin/hardware/message.does_not_exist'));
    }
}
