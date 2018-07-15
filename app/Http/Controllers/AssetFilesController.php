<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Http\Requests\AssetFileRequest;
use App\Models\Actionlog;
use App\Models\Asset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class AssetFilesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Upload a file to the server.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @param AssetFileRequest $request
     * @param int $assetId
     * @return Redirect
     * @since [v1.0]
     */
    public function store(AssetFileRequest $request, $assetId = null)
    {
        if (!$asset = Asset::find($assetId)) {
            return redirect()->route('hardware.index')->with('error', trans('admin/hardware/message.does_not_exist'));
        }

        $this->authorize('update', $asset);

        $destinationPath = config('app.private_uploads').'/assets';

        if ($request->hasFile('assetfile')) {
            foreach ($request->file('assetfile') as $file) {
                $extension = $file->getClientOriginalExtension();
                $filename = 'hardware-'.$asset->id.'-'.str_random(8);
                $filename .= '-'.str_slug(basename($file->getClientOriginalName(), '.'.$extension)).'.'.$extension;
                $file->move($destinationPath, $filename);
                $asset->logUpload($filename, e($request->get('notes')));
            }
            return redirect()->back()->with('success', trans('admin/hardware/message.upload.success'));
        }

        return redirect()->back()->with('error', trans('admin/hardware/message.upload.nofiles'));
    }

    /**
    * Check for permissions and display the file.
    *
    * @author [A. Gianotto] [<snipe@snipe.net>]
    * @param  int  $assetId
    * @param  int  $fileId
    * @since [v1.0]
    * @return View
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

            $file = $log->get_src('assets');

            if ($log->action_type =='audit') {
                $file = $log->get_src('audits');
            }

            if (!file_exists($file)) {
                return response('File '.$file.' not found on server', 404)
                    ->header('Content-Type', 'text/plain');
            }

            if ($download != 'true') {
                  if ($contents = file_get_contents($file)) {
                      return Response::make($contents)->header('Content-Type', $filetype);
                  }
                return JsonResponse::create(["error" => "Failed validation: "], 500);
            }
            return Response::download($file);
        }
        // Prepare the error message
        $error = trans('admin/hardware/message.does_not_exist', compact('id'));

        // Redirect to the hardware management page
        return redirect()->route('hardware.index')->with('error', $error);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
    * Delete the associated file
    *
    * @author [A. Gianotto] [<snipe@snipe.net>]
    * @param  int  $assetId
    * @param  int  $fileId
    * @since [v1.0]
    * @return View
    */
    public function destroy($assetId = null, $fileId = null)
    {
        $asset = Asset::find($assetId);
        $this->authorize('update', $asset);
        $destinationPath = config('app.private_uploads').'/imports/assets';

        // the asset is valid
        if (isset($asset->id)) {
            $this->authorize('update', $asset);

            $log = Actionlog::find($fileId);
            $full_filename = $destinationPath.'/'.$log->filename;
            if (file_exists($full_filename)) {
                unlink($destinationPath.'/'.$log->filename);
            }
            $log->delete();
            return redirect()->back()->with('success', trans('admin/hardware/message.deletefile.success'));
        }

        // Redirect to the hardware management page
        return redirect()->route('hardware.index')->with('error', trans('admin/hardware/message.does_not_exist'));
    }
}
