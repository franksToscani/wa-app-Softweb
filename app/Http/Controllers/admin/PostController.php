<?php

namespace App\Http\Controllers\Admin;

use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PostController extends Controller
{
    public function index()
    {
        // We no longer maintain a separate admin posts index page.
        // Redirect to the central dashboard which contains the posts list.
        return redirect()->route('dashboard');
    }

    public function create()
    {
        return Inertia::render('admin/posts/Create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'nullable|string',
        ]);

        // TODO: implement real storage logic (media, relations, user id, statuses)
        // For now, redirect to the dashboard as a placeholder outcome.
        return redirect()->route('dashboard')->with('success', 'Post creato (placeholder).');
    }
}
