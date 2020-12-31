<?php

namespace App\Http\Controllers;

use App\Jobs\ProcessPropertyUrlJob;
use App\Models\Property;
use App\Models\PropertyPreference;
use Illuminate\Http\Request;

class PropertyController extends Controller
{
    /**
     * Dislike the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Property $property
     * @return \Illuminate\Http\RedirectResponse
     */
    public function dislike(Request $request, Property $property)
    {
        $user = $request->user();

        if (! $user->can('dislike', $property)) {
            abort(403);
        }

        PropertyPreference::firstOrCreate([
            'property_id' => $property->id,
            'user_id' => $user->id,
        ], ['is_liked' => false]);

        return back();
    }

    /**
     * Like the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Property $property
     * @return \Illuminate\Http\RedirectResponse
     */
    public function like(Request $request, Property $property)
    {
        $user = $request->user();

        if (! $user->can('like', $property)) {
            abort(403);
        }

        PropertyPreference::firstOrCreate([
            'property_id' => $property->id,
            'user_id' => $user->id,
        ], ['is_liked' => true]);

        return back();
    }

    /**
     * Reprocess the specified resource's details.
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function reprocess($id)
    {
        $model = Property::findOrFail($id);

        dispatch(new ProcessPropertyUrlJob($model, $model->url));

        return back();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'url' => 'required|string|url|max:2000|starts_with:http',
        ]);

        // Remove query string
        $url = strtok($request->get('url'), '?');

        $model = Property::create([
            'status_id' => config('app.statuses.queued_id'),
            'url' => $url,
            'user_id' => $request->user()->id,
        ]);

        dispatch(new ProcessPropertyUrlJob($model, $model->url));

        return redirect()->route('properties.show', $model);
    }

    /**
     * Display the specified resource.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\View\View
     */
    public function show(Request $request, $id)
    {
        $model = Property::findOrFail($id)->load(['property_preferences.user']);

        $user_preference = $model->property_preferences
            ->where('property_id', $model->id)
            ->where('user_id', $request->user()->id)
            ->first();

        return view('properties.show')
            ->with('model', $model)
            ->with('user_preference', $user_preference);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        Property::findOrFail($id)->delete();

        return redirect()->route('dashboard');
    }
}
