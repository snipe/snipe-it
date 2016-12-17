<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use Response;

class ActionlogController extends Controller
{
    public function displaySig($filename)
    {
        $this->authorize('view', \App\Models\Asset::class);
        $file = config('app.private_uploads') . '/signatures/' . $filename;
        $filetype = Helper::checkUploadIsImage($file);
        $contents = file_get_contents($file);
        return Response::make($contents)->header('Content-Type', $filetype);
    }
}
