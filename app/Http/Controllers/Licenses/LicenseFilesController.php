<?php

namespace App\Http\Controllers\Licenses;

use App\Helpers\StorageHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\FileAttachmentRequest;
use App\Models\Actionlog;
use App\Models\License;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\JsonResponse;
use enshrined\svgSanitize\Sanitizer;

class LicenseFilesController extends Controller
{
    /**
     * Validates and stores files associated with a license.
     *
     * @param FileAttachmentRequest $request
     * @param int $licenseId
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v1.0]
     */
    public function store(FileAttachmentRequest $request, $licenseId = null)
    {
        if (!$license = License::find($licenseId)) {
            return redirect()->route('licenses.index')->with('error', trans('admin/licenses/message.does_not_exist'));
        }

        $this->authorize('update', $license);
        $license->storeFiles($request->file('file'), $request->get('notes'));
        return redirect()->back()->with('success', trans('admin/licenses/message.upload.success'));
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
        if (!$license = Asset::find($licenseId)) {
            // Redirect to the hardware management page
            return redirect()->route('licenses.index')->with('error', trans('admin/licenses/message.does_not_exist'));
        }

        $this->authorize('update', $license);
        if ($log = Actionlog::find($fileId)) {
            $license->destroyFile($log);
        }
        return redirect()->back()->with('success', trans('admin/hardware/message.deletefile.success'));
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
        if (!$license = License::find($licenseId)) {
            return redirect()->route('licenses.index')->with('error',
                trans('admin/licenses/message.does_not_exist', ['id' => $fileId]));
        }
        $this->authorize('view', $license);

        if (!$log = Actionlog::find($fileId)) {
            return response('No matching record for that license/file', 500)
                ->header('Content-Type', 'text/plain');
        }
        return $license->showFile($log->filename);
    }
}