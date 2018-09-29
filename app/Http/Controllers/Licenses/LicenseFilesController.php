<?php

namespace App\Http\Controllers\Licenses;

use App\Http\Requests\AssetFileRequest;
use App\Models\Actionlog;
use App\Models\License;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Illuminate\Support\Facades\Storage;

class LicenseFilesController extends Controller
{

    /**
     * Validates and stores files associated with a license.
     *
     * @todo Switch to using the AssetFileRequest form request validator.
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v1.0]
     * @param AssetFileRequest $request
     * @param int $licenseId
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(AssetFileRequest $request, $licenseId = null)
    {
        $license = License::find($licenseId);
        // the license is valid
        $destinationPath = config('app.private_uploads').'/licenses';

        if (isset($license->id)) {
            $this->authorize('update', $license);

            if (Input::hasFile('file')) {
                $upload_success = false;
                foreach (Input::file('file') as $file) {
                    $extension = $file->getClientOriginalExtension();
                    $filename = 'license-'.$license->id.'-'.str_random(8).'-'.str_slug(basename($file->getClientOriginalName(), '.'.$extension)).'.'.$extension;

                    $upload_success = $file->storeAs('storage/private_uploads/licenses', $filename);

                    //Log the upload to the log
                    $license->logUpload($filename, e($request->input('notes')));
                }
                // This being called from a modal seems to confuse redirect()->back()
                // It thinks we should go to the dashboard.  As this is only used
                // from the modal at present, hardcode the redirect.  Longterm
                // maybe we evaluate something else.
                if ($upload_success) {
                    return redirect()->route('licenses.show', $license->id)->with('success', trans('admin/licenses/message.upload.success'));
                }
                return redirect()->route('licenses.show', $license->id)->with('error', trans('admin/licenses/message.upload.error'));
            }
            return redirect()->route('licenses.show', $license->id)->with('error', trans('admin/licenses/message.upload.nofiles'));
        }
        // Prepare the error message
        return redirect()->route('licenses.index')
            ->with('error', trans('admin/licenses/message.does_not_exist'));
    }


    /**
     * Deletes the selected license file.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v1.0]
     * @param int $licenseId
     * @param int $fileId
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy($licenseId = null, $fileId = null)
    {
        $license = License::find($licenseId);

        $rel_path = 'storage/private_uploads/licenses';

        // the asset is valid
        if (isset($license->id)) {
            $this->authorize('update', $license);
            $log = Actionlog::find($fileId);
            if (file_exists(base_path().'/'.$rel_path.'/'.$log->filename)) {
                Storage::disk('public')->delete($rel_path.'/'.$log->filename);
            }
            $log->delete();
            return redirect()->back()
                ->with('success', trans('admin/hardware/message.deletefile.success'));
        }

        // Redirect to the licence management page
        return redirect()->route('licenses.index')->with('error', trans('admin/licenses/message.does_not_exist'));
    }



    /**
     * Allows the selected file to be viewed.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v1.4]
     * @param int $licenseId
     * @param int $fileId
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function show($licenseId = null, $fileId = null, $download = true)
    {

        $license = License::find($licenseId);

        // the license is valid
        if (isset($license->id)) {
            $this->authorize('view', $license);
            $log = Actionlog::find($fileId);
            $file = $log->get_src('licenses');


            if ($file =='') {
                return response('File not found on server', 404)
                    ->header('Content-Type', 'text/plain');
            }

            $mimetype = \File::mimeType($file);


            if (!file_exists($file)) {
                return response('File '.$file.' not found on server', 404)
                    ->header('Content-Type', 'text/plain');
            }

            if ($download != 'true') {
                if ($contents = file_get_contents($file)) {
                    return Response::make($contents)->header('Content-Type', $mimetype);
                }
                return JsonResponse::create(["error" => "Failed validation: "], 500);
            }
            return Response::download($file);
        }


        return redirect()->route('licenses.index')->with('error', trans('admin/licenses/message.does_not_exist'));
    }



}
