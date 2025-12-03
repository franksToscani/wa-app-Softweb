<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Models\Media;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use App\Http\Controllers\Controller;

class MediaController extends Controller
{
    /**
     * Display a listing of media files
     */
    public function index()
    {
        $media = Media::orderBy('created_at', 'desc')->get();
        
        return Inertia::render('Admin/Media/Index', [
            'media' => $media,
        ]);
    }
    
    /**
     * Show the form for creating a new media file
     */
    public function create()
    {
        return Inertia::render('Admin/Media/Create');
    }
    
    /**
     * Store a newly uploaded media file
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'file' => 'required|file|max:10240', // max 10MB
            'name' => 'nullable|string|max:255',
            'description' => 'nullable|string',
        ]);
        
        //Uso dell'API di Laravel per gestire l'upload dei file    
        $file = $request->file('file');
        $path = $file->store('media', 'public');
        
        $media = Media::create([
            'name' => $validated['name'] ?? $file->getClientOriginalName(),
            'file_name' => $file->getClientOriginalName(),
            'file_path' => $path,
            'url' => Storage::url($path),
            'mime_type' => $file->getMimeType(),
            'size' => $file->getSize(),
            'uploaded_by' => Auth::id(),
        ]);
        
        return redirect()->route('admin.media.index')
            ->with('success', 'Media caricato con successo.');
    }
    
    /**
     * Display the specified media file
     */
    public function show(Media $media)
    {
        return Inertia::render('Admin/Media/Show', [
            'media' => $media,
        ]);
    }
    
    /**
     * Show the form for editing the specified media
     */
    public function edit(Media $media)
    {
        return Inertia::render('Admin/Media/Edit', [
            'media' => $media,
        ]);
    }
    
    /**
     * Update the specified media in storage
     */
    public function update(Request $request, Media $media)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);
        
        $media->update($validated);
        
        return redirect()->route('admin.media.index')
            ->with('success', 'Media aggiornato con successo.');
    }
    
    /**
     * Remove the specified media from storage
     */
    public function destroy(Media $media)
    {
        // Delete physical file
        if ($media->file_path && Storage::disk('public')->exists($media->file_path)) {
            Storage::disk('public')->delete($media->file_path);
        }
        
        $media->delete();
        
        return redirect()->route('admin.media.index')
            ->with('success', 'Media eliminato con successo.');
    }
}
