<!-- Level Card Component -->
@php
    $colors = [
        '#667eea', '#764ba2',  // Purple gradient
        '#f093fb', '#f5576c',  // Pink gradient
        '#4facfe', '#00f2fe',  // Blue gradient
    ];
    
    $icons = [
        'bi-mortarboard',      // HND icon
        'bi-book-fill',        // Bachelor icon
        'bi-layers',           // Level icon
    ];
    
    $colorIndex = $color ?? 0;
    $iconIndex = $icon ?? 0;
    $gradient1 = $colors[$colorIndex % count($colors)] ?? '#667eea';
    $gradient2 = $colors[($colorIndex + 1) % count($colors)] ?? '#764ba2';
    $iconClass = $icons[$iconIndex % count($icons)] ?? 'bi-book';
@endphp

<div class="level-card h-100 rounded-lg shadow-hover transition-all">
    <div class="level-card-inner">
        <!-- Card Header -->
        <div class="level-card-header position-relative overflow-hidden">
            <div class="level-icon-bg" style="background: linear-gradient(135deg, {{ $gradient1 }} 0%, {{ $gradient2 }} 100%);"></div>
            <div class="level-icon-wrapper">
                <i class="bi {{ $iconClass }}" style="font-size: 2.5rem;"></i>
            </div>
        </div>

        <!-- Card Body -->
        <div class="level-card-body p-4">
            <h3 class="h5 fw-bold text-dark mb-2">{{ $level->name }}</h3>
            
            <p class="text-muted small mb-4" style="min-height: 3em; line-height: 1.5;">
                {{ Str::limit($level->description, 100) }}
            </p>

            <!-- Stats -->
            <div class="row g-2 mb-4">
                <div class="col-6">
                    <div class="stat-box text-center">
                        <div class="stat-number fw-bold text-primary">{{ $level->course_count }}</div>
                        <div class="stat-label small text-muted">Courses</div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="stat-box text-center">
                        <div class="stat-number fw-bold text-info">{{ $level->video_count }}</div>
                        <div class="stat-label small text-muted">Videos</div>
                    </div>
                </div>
            </div>

            <!-- CTA Button -->
            <a href="{{ route('level.show', $level) }}" class="btn btn-primary w-100 btn-hover">
                <span class="btn-text">Explore Level</span>
                <i class="bi bi-arrow-right ms-2"></i>
            </a>
        </div>

        <!-- Hover Effect Overlay -->
        <div class="level-card-overlay"></div>
    </div>
</div>

<style>
    .level-card {
        background: white;
        border: 1px solid #e9ecef;
        cursor: pointer;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .level-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1) !important;
        border-color: #667eea;
    }

    .level-card-inner {
        position: relative;
        z-index: 1;
    }

    .level-card-header {
        height: 120px;
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
    }

    .level-icon-bg {
        position: absolute;
        inset: 0;
        opacity: 0.9;
    }

    .level-icon-wrapper {
        position: relative;
        z-index: 2;
        color: white;
        animation: float 3s ease-in-out infinite;
    }

    @keyframes float {
        0%, 100% { transform: translateY(0px); }
        50% { transform: translateY(-10px); }
    }

    .level-card:hover .level-icon-wrapper {
        animation: float 2s ease-in-out infinite;
    }

    .stat-box {
        padding: 12px;
        background: #f8f9fa;
        border-radius: 8px;
        transition: all 0.3s ease;
    }

    .level-card:hover .stat-box {
        background: #e9ecef;
        transform: scale(1.05);
    }

    .stat-number {
        font-size: 1.5rem;
        line-height: 1;
    }

    .stat-label {
        margin-top: 4px;
    }

    .btn-hover {
        position: relative;
        overflow: hidden;
        transition: all 0.3s ease;
    }

    .btn-hover::before {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        width: 0;
        height: 0;
        background: rgba(255, 255, 255, 0.3);
        border-radius: 50%;
        transform: translate(-50%, -50%);
        transition: width 0.6s, height 0.6s;
    }

    .btn-hover:hover::before {
        width: 300px;
        height: 300px;
    }

    .btn-hover .btn-text {
        transition: all 0.3s ease;
    }

    .btn-hover:hover .btn-text {
        transform: translateX(2px);
    }

    .level-card-overlay {
        position: absolute;
        inset: 0;
        background: radial-gradient(circle at 50% 0%, rgba(102, 126, 234, 0.1), transparent 70%);
        opacity: 0;
        transition: opacity 0.3s ease;
        z-index: 0;
    }

    .level-card:hover .level-card-overlay {
        opacity: 1;
    }

    .shadow-hover {
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
    }

    .transition-all {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
</style>
