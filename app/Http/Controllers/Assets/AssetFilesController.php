<?php

namespace App\Http\Controllers\Assets;

use App\Helpers\StorageHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\AssetFileRequest;
use App\Models\Actionlog;
use App\Models\Asset;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use enshrined\svgSanitize\Sanitizer;

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
        if (! $asset = Asset::find($assetId)) {
            return redirect()->route('hardware.index')->with('error', trans('admin/hardware/message.does_not_exist'));
        }

        $this->authorize('update', $asset);

        if ($request->hasFile('file')) {
            if (! Storage::exists('private_uploads/assets')) {
                Storage::makeDirectory('private_uploads/assets', 775);
            }

            foreach ($request->file('file') as $file) {

                $extension = $file->getClientOriginalExtension();
                $file_name = 'hardware-'.$asset->id.'-'.str_random(8).'-'.str_slug(basename($file->getClientOriginalName(), '.'.$extension)).'.'.$extension;

                // Check for SVG and sanitize it
                if ($extension=='svg') {
                    \Log::debug('This is an SVG');

                        $sanitizer = new Sanitizer();
                        $dirtySVG = file_get_contents($file->getRealPath());
                        $cleanSVG = $sanitizer->sanitize($dirtySVG);

                        try {
                            Storage::put('private_uploads/assets/'.$file_name, $cleanSVG);
                        } catch (\Exception $e) {
                            \Log::debug('Upload no workie :( ');
                            \Log::debug($e);
                        }
                } else {
                Storage::put('private_uploads/assets/'.$file_name, file_get_contents($file));
                }
               
                
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

            if (! $log = Actionlog::find($fileId)) {
                return response('No matching record for that asset/file', 500)
                    ->header('Content-Type', 'text/plain');
            }

            $file = 'private_uploads/assets/'.$log->filename;
            \Log::debug('Checking for '.$file);

            if ($log->action_type == 'audit') {
                $file = 'private_uploads/audits/'.$log->filename;
            }

            if (! Storage::exists($file)) {
                return response('File '.$file.' not found on server', 404)
                    ->header('Content-Type', 'text/plain');
            }

            if ($download != 'true') {
                if ($contents = file_get_contents(Storage::url($file))) {
                    return Response::make(Storage::url($file)->header('Content-Type', mime_content_type($file)));
                }

                return JsonResponse::create(['error' => 'Failed validation: '], 500);
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

            return redirect()->back()
                ->with('success', trans('admin/hardware/message.deletefile.success'));
        }

        // Redirect to the hardware management page
        return redirect()->route('hardware.index')->with('error', trans('admin/hardware/message.does_not_exist'));
    }
}
