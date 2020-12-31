<?php

namespace App\Http\Controllers;

use App\Models\PropertyPreference;
use Illuminate\Http\Request;

class PropertyPreferenceController extends Controller
{
    /**
     * Remove the specified resource from storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\PropertyPreference $property_preference
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(
        Request $request,
        PropertyPreference $property_preference
    ) {
        if (! $request->user()->can('delete', $property_preference)) {
            abort(403);
        }

        $property_preference->delete();

        return back();
    }
}
