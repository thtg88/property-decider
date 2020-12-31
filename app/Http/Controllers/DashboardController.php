<?php

namespace App\Http\Controllers;

use App\Models\Property;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\View\View
     */
    public function __invoke(Request $request)
    {
        $user_groups = $request->user()->getUserGroups()->load(['user']);

        if ($user_groups->count() > 0) {
            $properties = Property::with(['property_preferences.user'])
                ->whereIn('user_id', $user_groups->pluck('user_id'))
                ->get();
        } else {
            $properties = new Collection();
        }

        return view('dashboard.main')
            ->with('properties', $properties)
            ->with('user_groups', $user_groups);
    }
}
