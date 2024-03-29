<?php

namespace App\Http\Controllers;

use App\Models\NotificationPreference;
use App\Models\NotificationType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class ProfileController extends Controller
{
    /**
     * Show the form for editing the specified resource.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\View\View
     */
    public function edit(Request $request)
    {
        $user = $request->user()->load(['notification_preferences']);

        return view('profile.edit.main')
            ->with('notification_types', NotificationType::all())
            ->with('user', $user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request)
    {
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
        ];
        $request->validate($rules);

        $user = $request->user();
        $old_email = $user->email;
        $data = array_intersect_key($request->all(), $rules);

        if ($old_email !== $data['email']) {
            $data['email_verified_at'] = null;
        }

        $user->update($data);

        if ($old_email !== $data['email']) {
            $user->sendEmailVerificationNotification();
        }

        return back();
    }

    /**
     * Update the specified resource's notification preferences in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateNotificationPreferences(Request $request)
    {
        $request->validate([
            'notification_preferences' => 'required|array',
            'notification_preferences.*' => 'required|array',
            'notification_preferences.*.is_active' => 'required|boolean',
            'notification_preferences.*.type_id' => [
                'required',
                'integer',
                Rule::exists('notification_types', 'id'),
            ],
        ]);

        $user = $request->user()->load(['notification_preferences']);

        // Create or update existing notification preferences
        $notification_preferences_data = $request->get(
            'notification_preferences'
        );
        foreach (NotificationType::all() as $notification_type) {
            $notification_preference = $user->notification_preferences
                ->firstWhere('type_id', $notification_type->id);
            $notification_preference_data = array_merge(
                $notification_preferences_data[$notification_type->id],
                ['user_id' => $user->id]
            );
            if ($notification_preference === null) {
                NotificationPreference::create($notification_preference_data);
                continue;
            }

            $notification_preference->update($notification_preference_data);
        }

        return back();
    }

    /**
     * Update the specified resource's password in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required|string',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = $request->user();
        $data = $request->all();
        $auth_data = [
            'email' => $user->email,
            'password' => $data['current_password'],
        ];

        if (! Auth::attempt($auth_data)) {
            throw ValidationException::withMessages([
                'current_password' => __('auth.failed'),
            ]);
        }

        $user->update(['password' => $data['password']]);

        return back();
    }
}
