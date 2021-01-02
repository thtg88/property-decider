<?php

namespace App\Http\Controllers;

use App\Helpers\PropertyHelper;
use App\Jobs\ProcessPropertyUrlJob;
use App\Models\Comment;
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
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Property $property
     * @return \Illuminate\Http\RedirectResponse
     */
    public function reprocess(Request $request, Property $property)
    {
        if (! $request->user()->can('reprocess', $property)) {
            abort(403);
        }

        dispatch(new ProcessPropertyUrlJob($property, $property->url));

        return back();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Helpers\PropertyHelper $helper
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request, PropertyHelper $helper)
    {
        $user = $request->user();

        if (! $user->can('create', Property::class)) {
            abort(403);
        }

        $request->validate([
            'url' => 'bail|required|string|url|starts_with:http|max:2000',
        ]);

        $model = Property::create([
            'status_id' => config('app.statuses.queued_id'),
            'url' => $helper->stripQuery($request->get('url')),
            'user_id' => $user->id,
        ]);

        dispatch(new ProcessPropertyUrlJob($model, $model->url));

        return redirect()->route('properties.show', $model);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Helpers\Property $property
     * @return \Illuminate\Http\RedirectResponse
     */
    public function storeComment(Request $request, Property $property)
    {
        $user = $request->user();

        if (! $user->can('createComment', $property)) {
            abort(403);
        }

        $request->validate(['content' => 'required|string|max:65535']);

        $model = Comment::create([
            'content' => $request->get('content'),
            'property_id' => $property->id,
            'user_id' => $user->id,
        ]);

        // TODO: Notify group of comment?

        return redirect(route('properties.show', $property).'#comments');
    }

    /**
     * Display the specified resource.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Property $property
     * @return \Illuminate\View\View
     */
    public function show(Request $request, Property $property)
    {
        $user = $request->user();

        if (! $user->can('view', $property)) {
            abort(403);
        }

        $property = $property->load(['property_preferences.user']);

        $user_preference = $property->property_preferences
            ->where('property_id', $property->id)
            ->where('user_id', $request->user()->id)
            ->first();

        return view('properties.show.main')
            ->with('model', $property)
            ->with('user_preference', $user_preference);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Property $property
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request, Property $property)
    {
        if (! $request->user()->can('delete', $property)) {
            abort(403);
        }

        $property->delete();

        return redirect()->route('dashboard');
    }
}
