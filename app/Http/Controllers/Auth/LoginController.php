<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Symfony\Bridge\PsrHttpMessage\Factory\HttpFoundationFactory;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Auth;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Hash;
use DB;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    public function login(Request $request)
    {
        DB::beginTransaction();

        $client = new Client();

        // Intial company
        if($request->company == 'bpu') {
            $companyIntial = '1';
        }else{
            $companyIntial = '2';
        }

        // API endpoint you want to hit
        if($companyIntial == '1') {
            $apiEndpoint = 'http://10.10.30.14:1024/login?plant=bpu';
        }else{
            $apiEndpoint = 'http://10.10.30.14:1024/login?plant=skb3';
        }

        try {
            $response = $client->post($apiEndpoint, [
                'auth' => [$request->username, $request->password],
            ]);

            // If the external API returns a successful response, proceed with Laravel authentication
            if ($response->getStatusCode() == 201) {
                $userErp = json_decode($response->getBody(), true);

                $userHelpdesk = User::where('id_people',$userErp['authData']['id_people'])
                                        ->where('company_id',$companyIntial)
                                        ->first();

                if($userHelpdesk) {
                    if($userErp['authData']['userid'] != $userHelpdesk->username || $userErp['authData']['username'] != $userHelpdesk->name || $request->password != $userHelpdesk->password_text) {
                        User::where('id_people',$userErp['authData']['id_people'])->update([
                            'username' => $userErp['authData']['userid'],
                            'name' => strtolower($userErp['authData']['username']),
                            'password' => Hash::make($request->password),
                            'password_text' => $request->password
                        ]);
                    }

                    DB::commit();

                    $credentials = $request->only('username', 'password');

                    if (Auth::attempt($credentials)) {
                        return redirect()->intended('home');
                    }else{
                        DB::rollback();

                        toast('Cant log in, contact administrator','error');

                        return back();
                    }
                }else{
                    User::create([
                        'name' => strtolower($userErp['authData']['username']),
                        'username' => $userErp['authData']['userid'],
                        'email' => 'default@bumipanganutama.com',
                        'company_id' => $companyIntial,
                        'password' => Hash::make($request->password),
                        'password_text' => $request->password,
                        'id_people' => $userErp['authData']['id_people']
                    ]);

                    DB::commit();

                    $credentials = $request->only('username', 'password');

                    if (Auth::attempt($credentials)) {
                        return redirect()->intended('home');
                    }else{
                        DB::rollback();

                        toast('Cant log in, contact administrator','error');

                        return back();
                    }
                }
            } else {
                toast('Account not found, please check again','error');

                return back();
            }
        } catch (\Exception $e) {
            toast('Connection to ERP is problematic, check connection','error');

            return back();
        }
    }

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function username()
    {
        $login = request()->input('username');
        $field = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
        request()->merge([$field => $login]);
        return $field;
    }

    public function logout() {
        Auth::logout();
        return redirect()->route('/');
    }
}
