<?php

namespace App\Http\Controllers\Licenses;

use App\Http\Controllers\Controller;
use App\Http\Requests\AssetFileRequest;
use App\Models\Actionlog;
use App\Models\License;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\JsonResponse;

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

        if (isset($license->id)) {
            $this->authorize('update', $license);

            if ($request->hasFile('file')) {

                if (!Storage::exists('private_uploads/licenses')) Storage::makeDirectory('private_uploads/licenses', 775);

                $upload_success = false;
                foreach ($request->file('file') as $file) {


                    $file_name = 'license-'.$license->id.'-'.str_random(8).'-'.str_slug(basename($file->getClientOriginalName(), '.'.$file->getClientOriginalExtension())).'.'.$file->getClientOriginalExtension();


                    $upload_success = $file->storeAs('private_uploads/licenses', $file_name);
                    // $upload_success = $file->storeAs('private_uploads/licenses/'.$file_name, $file);

                    //Log the upload to the log
                    $license->logUpload($file_name, e($request->input('notes')));
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

        // the asset is valid
        if (isset($license->id)) {
            $this->authorize('update', $license);
            $log = Actionlog::find($fileId);

            // Remove the file if one exists
            if (Storage::exists('licenses/'.$log->filename)) {
                try  {
                    Storage::delete('licenses/'.$log->filename);
                } catch (\Exception $e) {
                    \Log::debug($e);
                }
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

        \Log::info('Private filesystem is: '.config('filesystems.default') );
        $license = License::find($licenseId);

        // the license is valid
        if (isset($license->id)) {
            $this->authorize('view', $license);

            if (!$log = Actionlog::find($fileId)) {
                return response('No matching record for that asset/file', 500)
                    ->header('Content-Type', 'text/plain');
            }

            $file = 'private_uploads/licenses/'.$log->filename;


            if (Storage::missing($file)) {
                \Log::debug('NOT EXISTS for '.$file);
                \Log::debug('NOT EXISTS URL should be '.Storage::url($file));
                return response('File '.$file.' ('.Storage::url($file).') not found on server', 404)
                    ->header('Content-Type', 'text/plain');
            } else {

                // We have to override the URL stuff here, since local defaults in Laravel's Flysystem
                // won't work, as they're not accessible via the web
                if (config('filesystems.default') == 'local') {
                    return Storage::download($file);
                } else {
                    if ($download != 'true') {
                        \Log::debug('display the file');
                        if ($contents = file_get_contents(Storage::url($file))) {
                            return Response::make(Storage::url($file)->header('Content-Type', mime_content_type($file)));
                        }
                        return JsonResponse::create(["error" => "Failed validation: "], 500);
                    }

                    return Storage::download($file);
                }

            }


        }
        return redirect()->route('license.index')->with('error', trans('admin/licenses/message.does_not_exist', ['id' => $fileId]));

    }



}
