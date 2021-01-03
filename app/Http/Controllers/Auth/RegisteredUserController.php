<?php

namespace App\Http\Controllers\Auth;

use App\Helpers\NotificationPreferenceHelper;
use App\Http\Controllers\Controller;
use App\Models\NotificationPreference;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Helpers\NotificationPreferenceHelper $notification_preference_helper
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(
        Request $request,
        NotificationPreferenceHelper $notification_preference_helper
    ) {
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|confirmed|min:8',
        ];
        if (config('captcha.mode') === true) {
            $rules['g-recaptcha-response'] = 'required|captcha';
        }

        $request->validate($rules);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
        ]);

        $notification_preference_helper->createAll($user);

        Auth::login($user);

        event(new Registered($user));

        return redirect(RouteServiceProvider::HOME);
    }
}
