<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreVideoRequest;
use App\Http\Requests\UpdateVideoRequest;
use App\Models\Video;
use App\Models\Course;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class VideoController extends Controller
{
    /**
     * Display a listing of videos.
     */
    public function index()
    {
        $videos = Video::with('course')
            ->orderBy('order')
            ->paginate(20);
        
        return view('admin.videos.index', compact('videos'));
    }

    /**
     * Show the form for creating a new video.
     */
    public function create()
    {
        $courses = Course::where('is_active', true)
            ->orderBy('level_id')
            ->orderBy('order')
            ->get();
        
        return view('admin.videos.create', compact('courses'));
    }

    /**
     * Store a newly created video in storage.
     */
    public function store(StoreVideoRequest $request)
    {
        try {
            $data = $request->validated();
            
            // Handle file upload
            if ($request->hasFile('video_path')) {
                $file = $request->file('video_path');
                
                // Generate unique filename
                $filename = Str::slug($data['title']) . '_' . Str::random(8) . '.' . $file->getClientOriginalExtension();
                
                // Store file in public storage
                $path = $file->storeAs(
                    'videos/courses/' . $data['course_id'],
                    $filename,
                    'public'
                );
                
                $data['video_path'] = $path;
                $data['file_size'] = $file->getSize();
            }
            
            // Set video order
            $data['order'] = Video::where('course_id', $data['course_id'])->max('order') ?? 0;
            $data['order']++;
            
            // Set uploaded by user
            $data['uploaded_by'] = auth()->id();
            
            Video::create($data);
            
            return redirect()->route('admin.videos.index')
                ->with('success', 'Video uploaded successfully!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to upload video: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified video.
     */
    public function show(Video $video)
    {
        $video->load('course', 'notes');
        
        return view('admin.videos.show', compact('video'));
    }

    /**
     * Show the form for editing the specified video.
     */
    public function edit(Video $video)
    {
        $video->load('course');
        $courses = Course::where('is_active', true)
            ->orderBy('level_id')
            ->orderBy('order')
            ->get();
        
        return view('admin.videos.edit', compact('video', 'courses'));
    }

    /**
     * Update the specified video in storage.
     */
    public function update(UpdateVideoRequest $request, Video $video)
    {
        try {
            $data = $request->validated();
            
            // Handle file replacement
            if ($request->hasFile('video_path')) {
                // Delete old file if exists
                if ($video->video_path && Storage::disk('public')->exists($video->video_path)) {
                    Storage::disk('public')->delete($video->video_path);
                }
                
                $file = $request->file('video_path');
                
                // Generate unique filename
                $filename = Str::slug($data['title']) . '_' . Str::random(8) . '.' . $file->getClientOriginalExtension();
                
                // Store file in public storage
                $path = $file->storeAs(
                    'videos/courses/' . $data['course_id'],
                    $filename,
                    'public'
                );
                
                $data['video_path'] = $path;
                $data['file_size'] = $file->getSize();
            }
            
            $video->update($data);
            
            return redirect()->route('admin.videos.show', $video)
                ->with('success', 'Video updated successfully!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to update video: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified video from storage.
     */
    public function destroy(Video $video)
    {
        try {
            // Delete video file from storage
            if ($video->video_path && Storage::disk('public')->exists($video->video_path)) {
                Storage::disk('public')->delete($video->video_path);
            }
            
            // Delete associated notes
            $video->notes()->delete();
            
            // Delete the video record
            $video->delete();
            
            return redirect()->route('admin.videos.index')
                ->with('success', 'Video deleted successfully!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to delete video: ' . $e->getMessage());
        }
    }

    /**
     * Reorder videos within a course.
     */
    public function reorder(\Illuminate\Http\Request $request)
    {
        try {
            $order = $request->input('order', []);
            
            foreach ($order as $index => $videoId) {
                Video::where('id', $videoId)
                    ->update(['order' => $index + 1]);
            }
            
            return response()->json(['success' => true, 'message' => 'Videos reordered successfully!']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
}
