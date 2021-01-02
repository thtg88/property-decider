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

        $voted_property_ids = $properties->pluck('property_preferences')
            ->flatten()
            ->pluck('property_id')
            ->unique();
        if ($voted_property_ids->count() === 0) {
            $new_properties = $properties;
            $voted_properties = new Collection();
        } else {
            $new_properties = $properties->whereNotIn('id', $voted_property_ids);
            $voted_properties = $properties->whereIn('id', $voted_property_ids);
        }

        return view('dashboard.main')
            ->with('new_properties', $new_properties)
            ->with('voted_properties', $voted_properties)
            ->with('user_groups', $user_groups);
    }
}
