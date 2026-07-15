<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SchoolSettingsController extends Controller
{
    public function edit()
    {
        $school = app('current_school');
        return view('settings.edit', compact('school'));
    }

    public function update(Request $request)
    {
        $school = app('current_school');

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'logo' => 'nullable|image|max:1024',
        ]);

        $data = $request->only(['name', 'email', 'phone', 'address']);

        if ($request->hasFile('logo')) {
            $path = $request->file('logo')->store('logos', 'public');
            $data['logo'] = $path;
        }

        $school->update($data);

        return redirect()->route('school.settings')->with('success', 'Paramètres mis à jour avec succès.');
    }
}
