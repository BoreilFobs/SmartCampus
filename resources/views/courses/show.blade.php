@extends('layouts.app')

@section('title', $course->title . ' - ' . $course->level->name . ' - SmartCampus')

@section('description', $course->description . ' Learn with video lessons and comprehensive notes on SmartCampus.')

@section('content')
<div class="container-fluid">
    <div class="row g-4">
        <!-- Video Player and Main Content -->
        <div class="col-lg-8 order-lg-1 order-2">
            <!-- Video Player -->
            <div class="video-container fade-in-up" data-animate>
                <video id="courseVideo" controls>
                    <source src="" type="video/mp4">
                    Your browser does not support the video tag.
                </video>
            </div>

            <!-- Video Info -->
            <div class="card mb-4 fade-in-up" data-animate>
                <div class="card-body">
                    <h3 id="videoTitle" class="mb-3">Select a video to start</h3>
                    <p id="videoDescription" class="text-secondary mb-0"></p>
                </div>
            </div>

            <!-- Notes Section -->
            <div class="card fade-in-up" data-animate>
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">
                        <i class="bi bi-file-text"></i> Notes & Summary
                    </h5>
                    <a href="#" id="downloadPdf" class="btn btn-sm btn-primary" style="display: none;" target="_blank">
                        <i class="bi bi-download"></i> Download PDF
                    </a>
                </div>
                <div class="card-body">
                    <div id="notesContent">
                        <p class="text-secondary">Select a video to view its notes and summaries.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar: Course Info and Playlist -->
        <div class="col-lg-4 order-lg-2 order-1">
            <!-- Course Info Card -->
            <div class="card mb-4 sticky-top fade-in-up" data-animate style="top: 70px;">
                <div class="card-header">
                    <h5 class="mb-0">{{ $course->title }}</h5>
                </div>
                <div class="card-body">
                    <p class="text-secondary mb-3">{{ $course->description }}</p>
                    
                    <div class="mb-3">
                        <small class="text-muted">
                            <i class="bi bi-tag"></i> {{ $course->level->name }}
                        </small>
                    </div>

                    <div class="row g-2 text-center">
                        <div class="col-6">
                            <div class="p-3 bg-light rounded">
                                <h6 class="text-primary mb-0" style="font-size: 1.3rem;">{{ $videos->count() }}</h6>
                                <small class="text-secondary">Videos</small>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="p-3 bg-light rounded">
                                <h6 class="text-primary mb-0" style="font-size: 1.3rem;">~{{ $videos->count() * 25 }}m</h6>
                                <small class="text-secondary">Duration</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Playlist -->
            <div class="fade-in-up" data-animate>
                <h6 class="mb-3 fw-bold">
                    <i class="bi bi-list-ul"></i> Course Videos
                </h6>
                <div id="playlist" class="playlist">
                    @forelse($videos as $index => $video)
                        @php
                            // Prepare notes data
                            $notesData = [];
                            if ($video->notes) {
                                foreach ($video->notes as $note) {
                                    $notesData[] = [
                                        'content' => $note->content,
                                        'pdf_url' => $note->pdf_url
                                    ];
                                }
                            }
                        @endphp
                        <div 
                            class="playlist-item {{ $index === 0 ? 'active' : '' }}" 
                            data-video-id="{{ $video->id }}"
                            data-video-url="{{ asset('storage/' . $video->video_path) }}"
                            data-video-title="{{ $video->title }}"
                            data-video-description="{{ $video->description }}"
                            data-notes="{{ json_encode($notesData) }}"
                            onclick="playVideo(this)"
                        >
                            <div class="d-flex align-items-center">
                                <span class="badge badge-primary me-2">{{ $index + 1 }}</span>
                                <div class="flex-grow-1 min-width-0">
                                    <div class="playlist-item-title text-truncate">
                                        {{ $video->title }}
                                    </div>
                                    <div class="playlist-item-duration">
                                        ~{{ $video->duration ?? 25 }} min
                                    </div>
                                </div>
                                <i class="bi bi-play-fill text-primary ms-2" style="display: none;"></i>
                            </div>
                        </div>
                    @empty
                        <p class="text-secondary text-center py-4">No videos available for this course.</p>
                    @endforelse
                </div>
            </div>

            <!-- Navigation Buttons -->
            <div class="d-flex gap-2 mt-4">
                <a href="{{ route('level.show', $course->level->slug) }}" class="btn btn-outline-primary flex-grow-1">
                    <i class="bi bi-arrow-left"></i> Back
                </a>
                <button class="btn btn-outline-primary" id="nextBtn" onclick="goToNextVideo()" title="Next video">
                    <i class="bi bi-arrow-right"></i>
                </button>
            </div>
        </div>
    </div>
</div>
<script>
    let currentVideoIndex = 0;
    const playlistItems = document.querySelectorAll('.playlist-item');
    const totalVideos = playlistItems.length;

    function playVideo(element) {
        document.querySelectorAll('.playlist-item').forEach(item => {
            item.classList.remove('active');
            item.querySelector('.bi-play-fill').style.display = 'none';
        });

        element.classList.add('active');
        element.querySelector('.bi-play-fill').style.display = 'block';

        const videoUrl = element.getAttribute('data-video-url');
        const videoTitle = element.getAttribute('data-video-title');
        const videoDescription = element.getAttribute('data-video-description');
        const videoId = element.getAttribute('data-video-id');

        document.getElementById('courseVideo').src = videoUrl;
        document.getElementById('videoTitle').textContent = videoTitle;
        document.getElementById('videoDescription').textContent = videoDescription;

        currentVideoIndex = Array.from(playlistItems).indexOf(element);

        // Load notes for this video
        loadVideoNotes(videoId);

        if (window.innerWidth < 768) {
            document.getElementById('courseVideo').scrollIntoView({ behavior: 'smooth' });
        }
    }

    function loadVideoNotes(videoId) {
        const notesContent = document.getElementById('notesContent');
        const downloadPdf = document.getElementById('downloadPdf');

        // Show loading state
        notesContent.innerHTML = '<div class="spinner-border spinner-border-sm" role="status"><span class="visually-hidden">Loading...</span></div> Loading notes...';
        downloadPdf.style.display = 'none';

        // Fetch notes from the video element's data attributes
        const videoElement = document.querySelector(`[data-video-id="${videoId}"]`);
        const videoData = {
            notes: videoElement.getAttribute('data-notes') || '[]',
            pdfUrl: videoElement.getAttribute('data-pdf-url') || ''
        };

        try {
            const notes = JSON.parse(videoData.notes);

            if (notes.length === 0) {
                notesContent.innerHTML = '<p class="text-secondary">No notes available for this video.</p>';
                downloadPdf.style.display = 'none';
                return;
            }

            // Display notes content (summary)
            let notesHtml = '';
            let hasPdf = false;

            notes.forEach(note => {
                if (note.content) {
                    notesHtml += `<div class="mb-3">${note.content}</div>`;
                }
                if (note.pdf_url) {
                    hasPdf = true;
                    downloadPdf.href = note.pdf_url;
                    downloadPdf.setAttribute('download', '');
                }
            });

            if (notesHtml) {
                notesContent.innerHTML = notesHtml;
            } else {
                notesContent.innerHTML = '<p class="text-secondary">No summary available for this video.</p>';
            }

            // Show download button only if PDF exists
            downloadPdf.style.display = hasPdf ? 'block' : 'none';

        } catch (e) {
            notesContent.innerHTML = '<p class="text-secondary">No notes available for this video.</p>';
            downloadPdf.style.display = 'none';
        }
    }

    function goToNextVideo() {
        if (currentVideoIndex < totalVideos - 1) {
            playlistItems[currentVideoIndex + 1].click();
        }
    }

    function goToPreviousVideo() {
        if (currentVideoIndex > 0) {
            playlistItems[currentVideoIndex - 1].click();
        }
    }

    document.addEventListener('keydown', (e) => {
        if (e.key === 'ArrowRight') goToNextVideo();
        if (e.key === 'ArrowLeft') goToPreviousVideo();
        if (e.code === 'Space') {
            e.preventDefault();
            const video = document.getElementById('courseVideo');
            video.paused ? video.play() : video.pause();
        }
    });

    document.addEventListener('DOMContentLoaded', () => {
        const firstVideoElement = playlistItems[0];
        if (firstVideoElement) {
            firstVideoElement.click();
        }
    });
</script>
@endsection
