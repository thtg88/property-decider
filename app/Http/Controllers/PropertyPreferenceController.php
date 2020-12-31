<?php

namespace App\Http\Controllers;

use App\Models\PropertyPreference;

class PropertyPreferenceController extends Controller
{
    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     * @param \App\Models\PropertyPreference $property_preference
     */
    public function destroy(
        PropertyPreference $property_preference
    ) {
        $property_preference->delete();

        return back();
    }
}
