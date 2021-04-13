<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use http\Exception;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use Auth;
use Config;
use Input;
use Laravel\Passport\TokenRepository;
use Redirect;
use Log;
use DB;
use View;
use PragmaRX\Google2FA\Google2FA;

class AuthController extends Controller
{

//
//    /**
//     * Create a new authentication controller instance.
//     *
//     * @return void
//     */
    public function __construct(TokenRepository $tokenRepository)
    {
//        $this->middleware('guest');
        $this->tokenRepository = $tokenRepository;
    }


    public function getToken(Request $request) {
        if ($request->filled('username') && $request->filled('password')) {
            $login = $request->get('username');
            $password= $request->get('password');
            if (Auth::validate(['username' => $login, 'password' => $password, 'activated' => 1])){

                try {
                    $user = User::where('username', '=', $login)->whereNull('deleted_at')->where('activated', '=', '1')->first();
                    if(!is_null($user)) {
                        $token =$user->createToken(
                            $request->name, $request->scopes ?: []
                        );
                        $arr = [
                            "username"=>$login,
                            "token"=>$token->accessToken
                        ];
                        return json_encode($arr);
                    }
                } catch(Exception $e) {
                    Log::debug("There was an error authenticating the Remote user: " . $e->getMessage());
                }

                return $login;
            }else{
                return "Bad credentals";
            }
        }else{
            return "No credentals";
        }
    }
}

