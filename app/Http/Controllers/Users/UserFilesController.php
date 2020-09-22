<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Http\Requests\AssetFileRequest;
use App\Models\Actionlog;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

class UserFilesController extends Controller
{
    /**
     * Return JSON response with a list of user details for the getIndex() view.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v1.6]
     * @param AssetFileRequest $request
     * @param int $userId
     * @return string JSON
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(AssetFileRequest $request, $userId = null)
    {
        $user = User::find($userId);
        $destinationPath = config('app.private_uploads') . '/users';

        if (isset($user->id)) {
            $this->authorize('update', $user);

            $logActions = [];
            $files = $request->file('file');
            foreach($files as $file) {
                $extension = $file->getClientOriginalExtension();
                $filename = 'user-' . $user->id . '-' . str_random(8);
                $filename .= '-' . str_slug($file->getClientOriginalName()) . '.' . $extension;
                if (!$file->move($destinationPath, $filename)) {
                    return JsonResponse::create(["error" => "Unabled to move file"], 500);
                }
                //Log the uploaded file to the log
                $logAction = new Actionlog();
                $logAction->item_id = $user->id;
                $logAction->item_type = User::class;
                $logAction->user_id = Auth::id();
                $logAction->note = $request->input('notes');
                $logAction->target_id = null;
                $logAction->created_at = date("Y-m-d H:i:s");
                $logAction->filename = $filename;
                $logAction->action_type = 'uploaded';

                if (!$logAction->save()) {
                    return JsonResponse::create(["error" => "Failed validation: " . print_r($logAction->getErrors(), true)], 500);

                }
                $logActions[] = $logAction;
            }
//            dd($logActions);
            return JsonResponse::create($logActions);
        }
        return JsonResponse::create(["error" => "No User associated with this request"], 500);

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
            $full_filename = $destinationPath . '/' . $log->filename;
            if (file_exists($full_filename)) {
                unlink($destinationPath . '/' . $log->filename);
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
            return Response::download($file);
        }
        // Prepare the error message
        $error = trans('admin/users/message.user_not_found', ['id' => $userId]);

        // Redirect to the licence management page
        return redirect()->route('users.index')->with('error', $error);
    }

}
