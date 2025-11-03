<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreNoteRequest;
use App\Http\Requests\UpdateNoteRequest;
use App\Models\Note;
use App\Models\Video;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class NoteController extends Controller
{
    /**
     * Display a listing of notes.
     */
    public function index()
    {
        $notes = Note::with('video', 'creator')
            ->orderBy('created_at', 'desc')
            ->paginate(15);
        
        return view('admin.notes.index', compact('notes'));
    }

    /**
     * Show the form for creating a new note.
     */
    public function create()
    {
        $videos = Video::where('is_active', true)
            ->with('course')
            ->orderBy('course_id')
            ->orderBy('order')
            ->get();
        
        return view('admin.notes.create', compact('videos'));
    }

    /**
     * Store a newly created note in storage.
     */
    public function store(StoreNoteRequest $request)
    {
        try {
            $data = $request->validated();
            
            // Handle PDF upload
            if ($request->hasFile('pdf_path')) {
                $file = $request->file('pdf_path');
                $filename = Str::slug(Video::find($data['video_id'])->title) . '_' . Str::random(8) . '.' . $file->getClientOriginalExtension();
                $path = $file->storeAs('notes', $filename, 'public');
                $data['pdf_path'] = $path;
            }
            
            $data['created_by'] = auth()->id();
            
            Note::create($data);
            
            return redirect()->route('admin.notes.index')
                ->with('success', 'Note created successfully!');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to create note: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Display the specified note.
     */
    public function show(Note $note)
    {
        $note->load('video', 'creator');
        
        return view('admin.notes.show', compact('note'));
    }

    /**
     * Show the form for editing the specified note.
     */
    public function edit(Note $note)
    {
        $note->load('video');
        
        $videos = Video::where('is_active', true)
            ->with('course')
            ->orderBy('course_id')
            ->orderBy('order')
            ->get();
        
        return view('admin.notes.edit', compact('note', 'videos'));
    }

    /**
     * Update the specified note in storage.
     */
    public function update(UpdateNoteRequest $request, Note $note)
    {
        try {
            $data = $request->validated();
            
            // Handle PDF replacement
            if ($request->hasFile('pdf_path')) {
                // Delete old PDF if it exists
                if ($note->pdf_path && Storage::disk('public')->exists($note->pdf_path)) {
                    Storage::disk('public')->delete($note->pdf_path);
                }
                
                $file = $request->file('pdf_path');
                $filename = Str::slug(Video::find($data['video_id'])->title) . '_' . Str::random(8) . '.' . $file->getClientOriginalExtension();
                $path = $file->storeAs('notes', $filename, 'public');
                $data['pdf_path'] = $path;
            } else {
                // Keep existing PDF if no new file is uploaded
                unset($data['pdf_path']);
            }
            
            $note->update($data);
            
            return redirect()->route('admin.notes.index')
                ->with('success', 'Note updated successfully!');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to update note: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Remove the specified note from storage.
     */
    public function destroy(Note $note)
    {
        try {
            // Delete PDF file if it exists
            if ($note->pdf_path && Storage::disk('public')->exists($note->pdf_path)) {
                Storage::disk('public')->delete($note->pdf_path);
            }
            
            $note->delete();
            
            return redirect()->route('admin.notes.index')
                ->with('success', 'Note deleted successfully!');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to delete note: ' . $e->getMessage());
        }
    }

    /**
     * Download the PDF attached to a note.
     */
    public function downloadPdf(Note $note)
    {
        try {
            if (!$note->pdf_path || !Storage::disk('public')->exists($note->pdf_path)) {
                return back()->with('error', 'PDF file not found!');
            }
            
            return Storage::disk('public')->download($note->pdf_path);
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to download PDF: ' . $e->getMessage());
        }
    }
}
