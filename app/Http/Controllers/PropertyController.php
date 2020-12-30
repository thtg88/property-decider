<?php

namespace App\Http\Controllers;

use App\Jobs\ProcessPropertyUrlJob;
use App\Models\Property;
use Illuminate\Http\Request;

class PropertyController extends Controller
{
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
     * @param int $id
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        return view('properties.show')
            ->with('model', Property::findOrFail($id));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Property::findOrFail($id)->delete();

        return redirect()->route('dashboard');
    }
}
