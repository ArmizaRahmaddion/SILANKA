<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     */
    protected string $redirectTo = '/dashboard';

    /**
     * Fields that can be used for authentication.
     *
     * @var string[]
     */
    protected array $loginFields = ['email', 'nik', 'nip'];

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }

    /**
     * Handle an authentication attempt.
     */
    public function login(Request $request): JsonResponse|\Illuminate\Http\RedirectResponse
    {
        $this->validateLogin($request);

        if (method_exists($this, 'hasTooManyLoginAttempts') && $this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        if ($this->attemptLogin($request)) {
            if ($request->hasSession()) {
                $request->session()->put('auth.password_confirmed_at', time());
            }

            return $this->sendLoginResponse($request);
        }

        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
    }

    /**
     * Send the response after the user was authenticated.
     */
    protected function sendLoginResponse(Request $request): JsonResponse|\Illuminate\Http\RedirectResponse
    {
        $request->session()->regenerate();

        $this->clearLoginAttempts($request);

        if ($response = $this->authenticated($request, $this->guard()->user())) {
            return $response;
        }

        return $request->wantsJson()
            ? new JsonResponse([], 204)
            : redirect()->intended($this->redirectPath());
    }

    /**
     * Attempt to log the user into the application.
     */
    protected function attemptLogin(Request $request): bool
    {
        $login = (string) $request->input('nipOrnik');
        $password = (string) $request->input('password');
        $remember = $request->boolean('remember');

        foreach ($this->loginFields as $field) {
            if ($this->guard()->attempt([$field => $login, 'password' => $password], $remember)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Validate the user login request.
     */
    protected function validateLogin(Request $request): void
    {
        $request->validate([
            'nipOrnik' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);
    }

    /**
     * Get the failed login response instance.
     *
     * @throws ValidationException
     */
    protected function sendFailedLoginResponse(Request $request): never
    {
        throw ValidationException::withMessages([
            'nipOrnik' => [trans('auth.failed')],
        ]);
    }

    /**
     * The user has been authenticated.
     */
    protected function authenticated(Request $request, $user): ?\Illuminate\Http\RedirectResponse
    {
        if ($user->hasRole(['superadmin', 'seknag', 'staff-tu'])) {
            Session::flash('confeti', true);
            return redirect()->intended($this->redirectTo)->with('success', 'Login Berhasil');
        }

        if ($user->hasRole(['masyarakat'])) {
            return redirect('/beranda')->with('success', 'Login Berhasil');
        }

        Auth::logout();

        return redirect()->route('login')->withErrors([
            'nipOrnik' => 'Anda tidak memiliki akses untuk login ke sistem ini.',
        ]);
    }

    /**
     * The user has logged out of the application.
     */
    protected function loggedOut(Request $request): \Illuminate\Http\RedirectResponse
    {
        return redirect(route('login'))->with('success', 'Anda telah berhasil logout dari sistem.');
    }
}
