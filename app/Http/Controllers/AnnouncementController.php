<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use App\Models\Classroom;
use Illuminate\Http\Request;

class AnnouncementController extends Controller
{
    public function index()
    {
        $announcements = Announcement::with(['author', 'classroom'])
            ->latest()
            ->get();

        return view('announcements.index', compact('announcements'));
    }

    public function create()
    {
        $classrooms = Classroom::all();

        return view('announcements.create', compact('classrooms'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'target' => 'required|in:all,classroom',
            'classroom_id' => 'nullable|required_if:target,classroom|exists:classrooms,id',
        ]);

        $validated['user_id'] = auth()->id();

        Announcement::create($validated);

        return redirect()->route('announcements.index')
            ->with('success', 'Annonce publiée avec succès.');
    }

    public function destroy(Announcement $announcement)
    {
        $announcement->delete();

        return redirect()->route('announcements.index')
            ->with('success', 'Annonce supprimée.');
    }
}
