<?php

namespace App\Http\Controllers\Api;

use App\Helpers\Helper;
use App\Helpers\StorageHelper;
use App\Http\Transformers\DatatablesTransformer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Ldap;
use App\Models\Setting;
use Mail;
use App\Notifications\SlackTest;
use App\Notifications\MailTest;
use GuzzleHttp\Client;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator; 
use App\Http\Requests\SlackSettingsRequest;
use App\Http\Transformers\LoginAttemptsTransformer;


class SettingsController extends Controller
{






    /**
     * Test the email configuration
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v3.0]
     * @return JsonResponse
     */
    public function ajaxTestEmail()
    {
        if (!config('app.lock_passwords')) {
            try {
                Notification::send(Setting::first(), new MailTest());
                return response()->json(['message' => 'Mail sent to '.config('mail.reply_to.address')], 200);
            } catch (\Exception $e) {
                return response()->json(['message' => $e->getMessage()], 500);
            }
        }
        return response()->json(['message' => 'Mail would have been sent, but this application is in demo mode! '], 200);

    }


    /**
     * Delete server-cached barcodes
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v5.0.0]
     * @return JsonResponse
     */
    public function purgeBarcodes()
    {
        $file_count = 0;
        $files = Storage::disk('public')->files('barcodes');

        foreach ($files as $file) { // iterate files

            $file_parts = explode('.', $file);
            $extension = end($file_parts);
            \Log::debug($extension);

            // Only generated barcodes would have a .png file extension
            if ($extension == 'png') {
                \Log::debug('Deleting: '.$file);


                try {
                    Storage::disk('public')->delete($file);
                    \Log::debug('Deleting: '.$file);
                    $file_count++;
                } catch (\Exception $e) {
                    \Log::debug($e);
                }
            }
        }

        return response()->json(['message' => 'Deleted '.$file_count.' barcodes'], 200);
    }





    /**
     * Get a list of login attempts
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v5.0.0]
     * @param  \Illuminate\Http\Request  $request
     * @return array | JsonResponse
     */
    public function showLoginAttempts(Request $request)
    {
        $allowed_columns = ['id', 'username', 'remote_ip', 'user_agent', 'successful', 'created_at'];

        $login_attempts = DB::table('login_attempts');
        $order = $request->input('order') === 'asc' ? 'asc' : 'desc';
        $sort = in_array($request->get('sort'), $allowed_columns) ? $request->get('sort') : 'created_at';

        $total = $login_attempts->count();
        $login_attempts->orderBy($sort, $order);
        $login_attempt_results = $login_attempts->skip(request('offset', 0))->take(request('limit', 20))->get();

        return (new LoginAttemptsTransformer)->transformLoginAttempts($login_attempt_results, $total);
    }


    /**
     * Lists backup files
     *
     * @author [A. Gianotto]
     * @return array | JsonResponse
     */
    public function listBackups() {
        $settings = Setting::getSettings();
        $path = 'app/backups';
        $backup_files = Storage::files($path);
        $files_raw = [];
        $count = 0;

        if (count($backup_files) > 0) {

            for ($f = 0; $f < count($backup_files); $f++) {

                // Skip dotfiles like .gitignore and .DS_STORE
                if ((substr(basename($backup_files[$f]), 0, 1) != '.')) {
                    $file_timestamp = Storage::lastModified($backup_files[$f]);

                    $files_raw[] = [
                        'filename' => basename($backup_files[$f]),
                        'filesize' => Setting::fileSizeConvert(Storage::size($backup_files[$f])),
                        'modified_value' => $file_timestamp,
                        'modified_display' => date($settings->date_display_format.' '.$settings->time_display_format, $file_timestamp),
                        'backup_url' => config('app.url').'/settings/backups/download/'.basename($backup_files[$f]),

                    ];
                    $count++;
                }

            }
        }

        $files = array_reverse($files_raw);
        return (new DatatablesTransformer)->transformDatatables($files, $count);

    }


    /**
     * Downloads a backup file.
     * We use response()->download() here instead of Storage::download() because Storage::download()
     * exhausts memory on larger files.
     *
     * @author [A. Gianotto]
     * @return JsonResponse|\Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function downloadBackup($file) {

        $path = storage_path('app/backups');
        
        if (Storage::exists('app/backups/'.$file)) {
            $headers = ['ContentType' => 'application/zip'];
            return response()->download($path.'/'.$file, $file, $headers);
        } else {
            return response()->json(Helper::formatStandardApiResponse('error', null,  trans('general.file_not_found')), 404);
        }

    }

    /**
     * Determines and downloads the latest backup
     *
     * @author [A. Gianotto]
     * @since [v6.3.1]
     * @return JsonResponse|\Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function downloadLatestBackup() {

        $fileData = collect();
        foreach (Storage::files('app/backups') as $file) {
            if (pathinfo($file, PATHINFO_EXTENSION) == 'zip') {
                $fileData->push([
                    'file' => $file,
                    'date' => Storage::lastModified($file)
                ]);
            }
        }

        $newest = $fileData->sortByDesc('date')->first();
        if (Storage::exists($newest['file'])) {
            $headers = ['ContentType' => 'application/zip'];
            return response()->download(storage_path($newest['file']), basename($newest['file']), $headers);
        } else {
            return response()->json(Helper::formatStandardApiResponse('error', null,  trans('general.file_not_found')), 404);
        }


    }


}