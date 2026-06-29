<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Announcement;

class AnnouncementController extends Controller
{
    public function index()
    {
        $announcements = Announcement::latest()->get();
        return view('admin.announcements', compact('announcements'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'type' => 'required|in:update,urgent,event',
            'date' => 'nullable|date',
            'time' => 'nullable|string',
        ]);

        Announcement::create($request->all());

        return redirect()->route('admin.announcements')->with('success', 'Announcement published successfully!');
    }

    public function destroy($id)
    {
        Announcement::findOrFail($id)->delete();
        return redirect()->route('admin.announcements')->with('success', 'Announcement deleted successfully!');
    }
}
