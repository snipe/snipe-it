<?php

namespace App\Http\Controllers\Consumables;

use App\Helpers\StorageHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\AssetFileRequest;
use App\Models\Actionlog;
use App\Models\Consumable;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use Symfony\Consumable\HttpFoundation\JsonResponse;
use enshrined\svgSanitize\Sanitizer;

class ConsumablesFilesController extends Controller
{
    /**
     * Validates and stores files associated with a consumable.
     *
     * @todo Switch to using the AssetFileRequest form request validator.
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v1.0]
     * @param AssetFileRequest $request
     * @param int $consumableId
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(AssetFileRequest $request, $consumableId = null)
    {
        if (config('app.lock_passwords')) {
            return redirect()->route('consumables.show', ['consumable'=>$consumableId])->with('error', trans('general.feature_disabled'));
        }

        $consumable = Consumable::find($consumableId);

        if (isset($consumable->id)) {
            $this->authorize('update', $consumable);

            if ($request->hasFile('file')) {
                if (! Storage::exists('private_uploads/consumables')) {
                    Storage::makeDirectory('private_uploads/consumables', 775);
                }

                foreach ($request->file('file') as $file) {

                    $extension = $file->getClientOriginalExtension();
                    $file_name = 'consumable-'.$consumable->id.'-'.str_random(8).'-'.str_slug(basename($file->getClientOriginalName(), '.'.$extension)).'.'.$extension;


                    // Check for SVG and sanitize it
                    if ($extension == 'svg') {
                        \Log::debug('This is an SVG');
                        \Log::debug($file_name);

                        $sanitizer = new Sanitizer();
                        $dirtySVG = file_get_contents($file->getRealPath());
                        $cleanSVG = $sanitizer->sanitize($dirtySVG);

                        try {
                            Storage::put('private_uploads/consumables/'.$file_name, $cleanSVG);
                        } catch (\Exception $e) {
                            \Log::debug('Upload no workie :( ');
                            \Log::debug($e);
                        }

                    } else {
                        Storage::put('private_uploads/consumables/'.$file_name, file_get_contents($file));
                    }

                    //Log the upload to the log
                    $consumable->logUpload($file_name, e($request->input('notes')));
                }


                return redirect()->route('consumables.show', $consumable->id)->with('success', trans('general.file_upload_success'));

            }

            return redirect()->route('consumables.show', $consumable->id)->with('error', trans('general.no_files_uploaded'));
        }
        // Prepare the error message
        return redirect()->route('consumables.index')
            ->with('error', trans('general.file_does_not_exist'));
    }

    /**
     * Deletes the selected consumable file.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v1.0]
     * @param int $consumableId
     * @param int $fileId
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy($consumableId = null, $fileId = null)
    {
        $consumable = Consumable::find($consumableId);

        // the asset is valid
        if (isset($consumable->id)) {
            $this->authorize('update', $consumable);
            $log = Actionlog::find($fileId);

            // Remove the file if one exists
            if (Storage::exists('consumables/'.$log->filename)) {
                try {
                    Storage::delete('consumables/'.$log->filename);
                } catch (\Exception $e) {
                    \Log::debug($e);
                }
            }

            $log->delete();

            return redirect()->back()
                ->with('success', trans('admin/hardware/message.deletefile.success'));
        }

        // Redirect to the licence management page
        return redirect()->route('consumables.index')->with('error', trans('general.file_does_not_exist'));
    }

    /**
     * Allows the selected file to be viewed.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v1.4]
     * @param int $consumableId
     * @param int $fileId
     * @return \Symfony\Consumable\HttpFoundation\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function show($consumableId = null, $fileId = null, $download = true)
    {
        $consumable = Consumable::find($consumableId);

        // the consumable is valid
        if (isset($consumable->id)) {
            $this->authorize('view', $consumable);
            $this->authorize('consumables.files', $consumable);

            if (! $log = Actionlog::find($fileId)) {
                return response('No matching record for that asset/file', 500)
                    ->header('Content-Type', 'text/plain');
            }

            $file = 'private_uploads/consumables/'.$log->filename;

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

        return redirect()->route('consumables.index')->with('error', trans('general.file_does_not_exist', ['id' => $fileId]));
    }
}
