<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AcceptInviteController extends Controller
{
    /**
     * Display the accept invite view for the given token.
     *
     * If no token is present, display the link request form.
     *
     * @param \Illuminate\Http\Request $request
     * @param string|null $token
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showAcceptInviteForm(Request $request, ?string $token = null)
    {
        return view('auth.accept-invite')
            ->with('token', $token)
            ->with('email', $request->email);
    }
}
