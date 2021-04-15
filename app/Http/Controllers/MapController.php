<?php


namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Http\Requests\FileUploadRequest;
use App\Models\Asset;
use App\Models\AssetModel;
use App\Models\Company;
use App\Models\Purchase;
use App\Models\Location;
use App\Models\Statuslabel;
use App\Models\User;
use DateTime;
use Illuminate\Support\Facades\Auth;

class MapController extends Controller
{
    public function index()
    {
        // Grab all the locations
        $this->authorize('view', Location::class);
        return view('map/index');
    }



}