<?php

namespace App\Http\Controllers\Accessories;

use App\Helpers\StorageHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\AssetFileRequest;
use App\Models\Actionlog;
use App\Models\Accessory;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use Symfony\Accessory\HttpFoundation\JsonResponse;
use enshrined\svgSanitize\Sanitizer;

class AccessoriesFilesController extends Controller
{
    /**
     * Validates and stores files associated with a accessory.
     *
     * @todo Switch to using the AssetFileRequest form request validator.
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v1.0]
     * @param AssetFileRequest $request
     * @param int $accessoryId
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(AssetFileRequest $request, $accessoryId = null)
    {

        if (config('app.lock_passwords')) {
            return redirect()->route('accessories.show', ['accessory'=>$accessoryId])->with('error', trans('general.feature_disabled'));
        }


        $accessory = Accessory::find($accessoryId);

        if (isset($accessory->id)) {
            $this->authorize('accessories.files', $accessory);

            if ($request->hasFile('file')) {
                if (! Storage::exists('private_uploads/accessories')) {
                    Storage::makeDirectory('private_uploads/accessories', 775);
                }

                foreach ($request->file('file') as $file) {

                    $extension = $file->getClientOriginalExtension();
                    $file_name = 'accessory-'.$accessory->id.'-'.str_random(8).'-'.str_slug(basename($file->getClientOriginalName(), '.'.$extension)).'.'.$extension;


                    // Check for SVG and sanitize it
                    if ($extension == 'svg') {
                        \Log::debug('This is an SVG');
                        \Log::debug($file_name);

                        $sanitizer = new Sanitizer();
                        $dirtySVG = file_get_contents($file->getRealPath());
                        $cleanSVG = $sanitizer->sanitize($dirtySVG);

                        try {
                            Storage::put('private_uploads/accessories/'.$file_name, $cleanSVG);
                        } catch (\Exception $e) {
                            \Log::debug('Upload no workie :( ');
                            \Log::debug($e);
                        }

                    } else {
                        Storage::put('private_uploads/accessories/'.$file_name, file_get_contents($file));
                    }

                    //Log the upload to the log
                    $accessory->logUpload($file_name, e($request->input('notes')));
                }


                return redirect()->route('accessories.show', $accessory->id)->with('success', trans('general.file_upload_success'));

            }

            return redirect()->route('accessories.show', $accessory->id)->with('error', trans('general.no_files_uploaded'));
        }
        // Prepare the error message
        return redirect()->route('accessories.index')
            ->with('error', trans('general.file_does_not_exist'));
    }

    /**
     * Deletes the selected accessory file.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v1.0]
     * @param int $accessoryId
     * @param int $fileId
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy($accessoryId = null, $fileId = null)
    {
        $accessory = Accessory::find($accessoryId);

        // the asset is valid
        if (isset($accessory->id)) {
            $this->authorize('update', $accessory);
            $log = Actionlog::find($fileId);

            // Remove the file if one exists
            if (Storage::exists('accessories/'.$log->filename)) {
                try {
                    Storage::delete('accessories/'.$log->filename);
                } catch (\Exception $e) {
                    \Log::debug($e);
                }
            }

            $log->delete();

            return redirect()->back()
                ->with('success', trans('admin/hardware/message.deletefile.success'));
        }

        // Redirect to the licence management page
        return redirect()->route('accessories.index')->with('error', trans('general.file_does_not_exist'));
    }

    /**
     * Allows the selected file to be viewed.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v1.4]
     * @param int $accessoryId
     * @param int $fileId
     * @return \Symfony\Accessory\HttpFoundation\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function show($accessoryId = null, $fileId = null, $download = true)
    {

        \Log::debug('Private filesystem is: '.config('filesystems.default'));
        $accessory = Accessory::find($accessoryId);



        // the accessory is valid
        if (isset($accessory->id)) {
            $this->authorize('view', $accessory);
            $this->authorize('accessories.files', $accessory);

            if (! $log = Actionlog::find($fileId)) {
                return response('No matching record for that asset/file', 500)
                    ->header('Content-Type', 'text/plain');
            }

            $file = 'private_uploads/accessories/'.$log->filename;

            if (Storage::missing($file)) {
                \Log::debug('FILE DOES NOT EXISTS for '.$file);
                \Log::debug('URL should be '.Storage::url($file));

                return response('File '.$file.' ('.Storage::url($file).') not found on server', 404)
                    ->header('Content-Type', 'text/plain');
            } else {

                // We have to override the URL stuff here, since local defaults in Laravel's Flysystem
                // won't work, as they're not accessible via the web
                if (config('filesystems.default') == 'local') { // TODO - is there any way to fix this at the StorageHelper layer?
                    return StorageHelper::downloader($file);
                } else {
                    if ($download != 'true') {
                        \Log::debug('display the file');
                        if ($contents = file_get_contents(Storage::url($file))) { // TODO - this will fail on private S3 files or large public ones
                            return Response::make(Storage::url($file)->header('Content-Type', mime_content_type($file)));
                        }

                        return JsonResponse::create(['error' => 'Failed validation: '], 500);
                    }

                    return StorageHelper::downloader($file);

                }
            }
        }

        return redirect()->route('accessories.index')->with('error', trans('general.file_does_not_exist', ['id' => $fileId]));
    }
}
