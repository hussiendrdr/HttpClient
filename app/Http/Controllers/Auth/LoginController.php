<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\MarketAuthenticationService;

use App\Services\MarketService;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';
    /**
     * The service to authenticate actions
     *
     * @var /App/Services/MarketAuthenticationService
     */
    protected $marketAuthenticationService;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(MarketAuthenticationService $marketAuthenticationService, MarketService $marketService)
    {
        $this->middleware('guest')->except('logout');

        $this->marketAuthenticationService = $marketAuthenticationService;

        parent::__construct($marketService);
    }


    /**
     * Show the application's login form.
     *
     * @return \Illuminate\View\View
     */
    public function showLoginForm()
    {
        $authorizationUrl = $this->marketAuthenticationService->resolveAuthorizationUrl();

        return view('auth.login')
            ->with(['authorizationUrl' => $authorizationUrl]);
    }
    public function authorization(Request $request)
    {
        if ($request->has('code')) {
            $tokenData = $this->marketAuthenticationService->getCodeToken($request->code);

        $userData = $this->marketService->getUserInformation();

           $user = $this->registerOrUpdateUser($userData, $tokenData);


            $this->loginUser($user);

            return redirect()->intended('home');
        }

        return redirect()
            ->route('login')
            ->withErrors(['You canecelled the authorization process']);
    }

    public function registerOrUpdateUser($userData, $tokenData)
    {
        return User::updateOrCreate(
            [
                'service_id' => $userData->identifier,
            ],
            [
                'grant_type' => $tokenData->grant_type,
                'access_token' => $tokenData->access_token,
                'refresh_token' => $tokenData->refresh_token,
                'token_expires_at' => $tokenData->token_expires_at,
            ]
        );
    }

    public function loginUser(User $user, $remember = true)
    {
        Auth::login($user, $remember);

        session()->regenerate();
    }
}
