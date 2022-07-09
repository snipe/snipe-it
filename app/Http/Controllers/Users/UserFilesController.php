<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Http\Requests\FileAttachmentRequest;
use App\Models\Actionlog;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use enshrined\svgSanitize\Sanitizer;
use Illuminate\Support\Facades\Storage;

class UserFilesController extends Controller
{
    /**
     * Return JSON response with a list of user details for the getIndex() view.
     *
     * @param FileAttachmentRequest $request
     * @param int $userId
     * @return string JSON
     * @throws \Illuminate\Auth\Access\AuthorizationException
     *@author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v1.6]
     */
    public function store(FileAttachmentRequest $request, $userId = null)
    {
        if (!$user = User::find($userId)) {
            return redirect()->route('users.index')
                ->with('error', trans('admin/users/message.user_not_found', ['id' => '$userId']));
        }

        $this->authorize('update', $user);
        $user->storeFiles($request->file('file'), $request->get('notes'));
        return redirect()->back()->with('success', trans('admin/users/message.upload.success'));
    }

    /**
     * Delete file
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v1.6]
     * @param  int $userId
     * @param  int $fileId
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy($userId = null, $fileId = null)
    {
        $user = User::find($userId);
        $destinationPath = config('app.private_uploads').'/users';

        if (isset($user->id)) {
            $this->authorize('update', $user);
            $log = Actionlog::find($fileId);
            $full_filename = $destinationPath.'/'.$log->filename;
            if (file_exists($full_filename)) {
                unlink($destinationPath.'/'.$log->filename);
            }
            $log->delete();

            return redirect()->back()->with('success', trans('admin/users/message.deletefile.success'));
        }
        // Prepare the error message
        $error = trans('admin/users/message.user_not_found', ['id' => $userId]);
        // Redirect to the licence management page
        return redirect()->route('users.index')->with('error', $error);

    }

    /**
     * Display/download the uploaded file
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v1.6]
     * @param  int $userId
     * @param  int $fileId
     * @return mixed
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function show($userId = null, $fileId = null)
    {
        $user = User::find($userId);

        // the license is valid
        if (isset($user->id)) {
            $this->authorize('view', $user);

            $log = Actionlog::find($fileId);
            $file = $log->get_src('users');

            return Response::download($file); //FIXME this doesn't use the new StorageHelper yet, but it's complicated...
        }
        // Prepare the error message
        $error = trans('admin/users/message.user_not_found', ['id' => $userId]);

        // Redirect to the licence management page
        return redirect()->route('users.index')->with('error', $error);
    }

}