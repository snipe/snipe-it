<?php
namespace App\Http\Controllers\Kits;

use App\Models\PredefinedKit;
use App\Models\AssetModel;
use App\Models\PredefinedModel;
use App\Models\License;
use App\Models\PredefinedLicence;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\ImageUploadRequest;
use App\Models\Accessory;
use App\Models\SnipeItPivot;
use Illuminate\Http\Request;
use App\Http\Controllers\CheckInOutRequest;
use App\Services\PredefinedKitCheckoutService;
use App\Models\User;




/**
 * This controller handles all access kits management:
 * list, add/remove/change
 *
 * @version    v2.0
 */
class CheckoutKitController extends Controller
{

    public $kitService;
    use CheckInOutRequest;

    
    public function __construct(PredefinedKitCheckoutService $kitService) 
    {
        $this->kitService = $kitService;
    }


    /**
    * Show Bulk Checkout Page
    * @return View View to checkout multiple assets
    */
    public function showCheckout($kit_id)
    {
        // METODO: добавить больше проверок, тут ещё и модель и прочее что мне надо бу
        $this->authorize('checkout', Asset::class);

        $kit = PredefinedKit::findOrFail($kit_id);
        return view('kits/checkout')->with('kit', $kit);
    }
    
    /**
    * Validate and process the new Predefined Kit data.
    *
    * @author [A. Gianotto] [<snipe@snipe.net>]
    * @since [v1.0]
    * @return Redirect
    */
    public function store(Request $request, $kit_id)
    {
        $user_id = e($request->get('user_id'));
        if ( is_null($user = User::find( $user_id )) ) {
            return redirect()->back()->with('error', trans('admin/users/message.user_not_found'));
        }

        $kit = new PredefinedKit();
        $kit->id = $kit_id;

        $errors = $this->kitService->checkout($request, $kit, $user);
        if( count($errors) > 0 ) {
            return redirect()->back()->with('error', 'Checkout error')->with('error_messages', $errors);  // TODO: trans
        }
        return redirect()->back()->with('success', 'Checkout was successfully');                                   // TODO: trans

    }
}
