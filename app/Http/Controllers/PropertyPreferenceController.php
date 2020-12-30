<?php

namespace App\Http\Controllers;

use App\Models\PropertyPreference;

class PropertyPreferenceController extends Controller
{
    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        PropertyPreference::findOrFail($id)->delete();

        return back();
    }
}
