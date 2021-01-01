<?php

namespace App\Http\Controllers;

use App\Helpers\UserGroupHelper;
use App\Models\User;
use App\Models\UserGroup;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class UserGroupController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Helpers\UserGroupHelper $helper
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request, UserGroupHelper $helper)
    {
        $current_user = $request->user();

        if (! $current_user->can('create', UserGroup::class)) {
            abort(403);
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
        ]);

        $user = User::firstOrCreate(['email' => $request->get('email')], [
            'name' => $request->get('name'),
            // User get automatically verified as invited by a trusted source
            'email_verified_at' => now()->toDateTimeString(),
            // Create a strong random password for the user to start with
            'password' => Str::random(30),
        ]);

        $helper->invite($user, $current_user);

        return redirect()->route('dashboard');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    // public function destroy($id)
    // {
    //     //
    // }
}
