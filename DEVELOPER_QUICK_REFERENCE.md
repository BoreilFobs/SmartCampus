# SmartCampus - Developer Quick Reference

## 📋 Quick Links to Code

### Views (Blade Templates)
- **Main Layout**: `resources/views/layouts/app.blade.php` (350+ lines)
- **Homepage**: `resources/views/welcome.blade.php` (175 lines)
- **Level Pages**: `resources/views/levels/show.blade.php` (145 lines)
- **Course Detail**: `resources/views/courses/show.blade.php` (220 lines)

### Controllers
- **HomeController**: `app/Http/Controllers/HomeController.php`
- **LevelController**: `app/Http/Controllers/LevelController.php`
- **CourseController**: `app/Http/Controllers/CourseController.php`

### Routes
- **File**: `routes/web.php`
- **Route**: `GET /` → HomeController@index
- **Route**: `GET /level/{level:slug}` → LevelController@show
- **Route**: `GET /course/{course:slug}` → CourseController@show

---

## 🎯 Key Implementation Details

### Main Layout Sections

```blade
<!-- Navigation Bar -->
<nav class="navbar navbar-expand-lg navbar-dark sticky-top">
    <!-- Mobile hamburger, Logo, Links, User menu -->
</nav>

<!-- Mobile Tabs (shown only on mobile) -->
<div class="mobile-tabs d-lg-none">
    <!-- Tab navigation -->
</div>

<!-- Desktop Sidebar (shown only on desktop) -->
<div class="sidebar d-none d-lg-block">
    <!-- Sidebar navigation -->
</div>

<!-- Main Content -->
<div class="main-content">
    <!-- Page content yields here -->
    @yield('content')
</div>

<!-- Footer -->
<footer>
    <!-- Footer content -->
</footer>
```

### Responsive Classes Used

```blade
<!-- Hide on mobile, show on desktop -->
<div class="d-none d-lg-block">Desktop only</div>

<!-- Show on mobile, hide on desktop -->
<div class="d-lg-none">Mobile only</div>

<!-- Responsive columns -->
<div class="col-12 col-md-6 col-lg-4">
    <!-- 1 col mobile, 2 col tablet, 4 col desktop -->
</div>

<!-- Responsive padding/margin -->
<div class="p-2 p-md-3 p-lg-4">
    <!-- 0.5rem mobile, 1rem tablet, 1.5rem desktop -->
</div>
```

---

## 🎨 CSS Styling Structure

### CSS Variables (in `app.blade.php`)
```css
:root {
    --primary-color: #667eea;
    --primary-dark: #5568d3;
    --secondary-color: #764ba2;
    --accent-color: #ffc107;
    --dark-bg: #1a1a2e;
    --light-bg: #f8f9fa;
    --card-bg: #ffffff;
    --text-primary: #1a1a2e;
    --text-secondary: #6c757d;
    --border-color: #e9ecef;
}
```

### Key CSS Classes

```css
/* Navigation */
.navbar { background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%); }
.sidebar { background: linear-gradient(180deg, var(--dark-bg) 0%, #2d2d44 100%); }

/* Cards */
.card { border: none; border-radius: 0.75rem; box-shadow: 0 2px 8px rgba(0,0,0,0.08); }
.card:hover { box-shadow: 0 4px 16px rgba(0,0,0,0.12); transform: translateY(-2px); }

/* Buttons */
.btn-primary { background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%); }

/* Grid */
.course-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 2rem; }

/* Animations */
@keyframes fadeInUp { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
.fade-in-up { animation: fadeInUp 0.6s ease-out; }
```

---

## 🔄 Data Flow

### Homepage
```
Route: GET /
↓
HomeController::index()
├── Fetch active levels with eager-loaded courses
├── Calculate statistics (totals, counts)
└── Return view('welcome', [...])
↓
Welcome View
├── Display levels grid (mapped from controller)
├── Show statistics cards
└── Display features and CTA
```

### Level Pages
```
Route: GET /level/{level:slug}
↓
LevelController::show($level)
├── Eager load courses with videos
├── Filter active courses
├── Calculate total videos
└── Return view('levels.show', [...])
↓
Level View
├── Display level header and stats
├── Show search box
├── Display course grid
├── Enable JavaScript search filtering
```

### Course Detail
```
Route: GET /course/{course:slug}
↓
CourseController::show($course)
├── Eager load videos and notes
├── Filter active videos
├── Sort by order
└── Return view('courses.show', [...])
↓
Course View
├── Display video player (first video auto-plays)
├── Show playlist sidebar
├── Update video/notes on selection
├── Enable keyboard navigation
```

---

## 📝 JavaScript Functions

### Homepage
- **Smooth Scroll**: `document.querySelectorAll('a[href^="#"]')` listeners
- **Animations**: IntersectionObserver for fade-in-up effects

### Level Pages
- **Search**: `courseSearch.addEventListener('keyup', ...)`
- **Filtering**: Toggle visibility, show/hide no-results message

### Course Pages
```javascript
playVideo(element)        // Play selected video
goToNextVideo()          // Navigate to next
goToPreviousVideo()      // Navigate to previous
loadNotes(videoId)       // Load video notes
// Keyboard shortcuts in DOMContentLoaded listener
```

---

## 🚀 Performance Optimizations

### Database Queries
```php
// Eager loading prevents N+1 queries
$level->load([
    'courses' => function ($query) {
        $query->where('is_active', true)
              ->orderBy('order')
              ->with(['videos' => function ($subQuery) {
                  $subQuery->where('is_active', true);
              }]);
    }
]);
```

### Frontend Optimization
- ✅ Bootstrap CDN (minified)
- ✅ Bootstrap Icons CDN
- ✅ Google Fonts (Poppins)
- ✅ Minimal custom CSS (inline in layout)
- ✅ Vanilla JavaScript (no jQuery)
- ✅ CSS animations (GPU accelerated)

### Asset Loading
```html
<!-- CSS at head -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<!-- JS at end (before closing body) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Custom JavaScript
</script>
```

---

## 🎯 Key Constants & Values

### Breakpoints
```css
Mobile:  < 768px
Tablet:  768px - 991px
Desktop: >= 992px
```

### Sidebar
```
Width: 250px
Z-index: 100
Position: Fixed (desktop only)
```

### Main Content
```
Mobile:  margin-left: 0
Desktop: margin-left: 250px
Padding: 1rem (mobile), 2rem (desktop)
```

### Grid
```
Course Card Min Width: 280px
Card Padding: 1.5rem
Gap: 2rem
```

### Animations
```
Duration: 0.3s - 0.6s
Timing: ease-out, ease-in-out
Type: CSS transitions & animations
```

---

## 🔍 Debugging Tips

### Check Responsive Design
```javascript
// Browser console
console.log(window.innerWidth);  // Current width
// Resize browser to test breakpoints
```

### Check Active Classes
```javascript
// Find all elements with data-animate
document.querySelectorAll('[data-animate]');

// Check if element has fade-in-up class
element.classList.contains('fade-in-up');
```

### Clear Cache
```bash
# Clear view cache
php artisan view:clear

# Clear config cache
php artisan config:clear

# Clear route cache
php artisan route:clear
```

### Check Database
```php
// In Tinker
php artisan tinker

// Check levels
Level::all();
Level::first()->courses;
Level::first()->courses->first()->videos;

// Check active records
Course::where('is_active', true)->count();
Video::where('is_active', true)->count();
```

---

## 📦 Dependencies

### Frontend
- Bootstrap 5.3.0 (CSS Framework)
- Bootstrap Icons (Icon Library)
- Google Fonts: Poppins (Typography)
- Vanilla JavaScript (No jQuery)

### Backend
- Laravel 10.x
- PHP 8.x
- SQLite (or MySQL/PostgreSQL)

### No External Dependencies For:
- Video player (HTML5 native)
- Animations (CSS native)
- Form validation (Bootstrap + Laravel)
- Search (JavaScript native)

---

## 🎯 Common Modifications

### Change Primary Color
```css
/* In app.blade.php <style> tag */
:root {
    --primary-color: #your-color;
}
```

### Add New Page
```blade
<!-- Create resources/views/pages/your-page.blade.php -->
@extends('layouts.app')
@section('title', 'Page Title')
@section('content')
    <!-- Your content -->
@endsection

<!-- Add route in routes/web.php -->
Route::get('/your-page', function() {
    return view('pages.your-page');
});
```

### Customize Sidebar
```blade
<!-- In app.blade.php, modify sidebar menu -->
<ul class="sidebar-menu">
    <li><a href="..."><i class="bi bi-icon"></i> Label</a></li>
</ul>
```

### Add Bootstrap Component
```blade
<!-- Just use Bootstrap classes -->
<button class="btn btn-primary">Click me</button>
<div class="alert alert-info">Message</div>
<div class="card">
    <div class="card-body">Content</div>
</div>
```

---

## ✅ Testing Checklist

- [ ] Homepage loads
- [ ] Level pages load and search works
- [ ] Course pages load with video player
- [ ] Video plays and playlist works
- [ ] Keyboard shortcuts work (arrow keys)
- [ ] Responsive design works on mobile (320px+)
- [ ] Responsive design works on tablet (768px+)
- [ ] Responsive design works on desktop (1024px+)
- [ ] Sidebar visible on desktop only
- [ ] Mobile tabs visible on mobile only
- [ ] All links navigate correctly
- [ ] Back buttons work
- [ ] No console errors
- [ ] Animations smooth
- [ ] Colors consistent
- [ ] Typography clear
- [ ] Touch targets large enough on mobile
- [ ] Forms submit correctly

---

## 📚 Resources

- **Laravel Docs**: https://laravel.com/docs
- **Bootstrap Docs**: https://getbootstrap.com/docs
- **Bootstrap Icons**: https://icons.getbootstrap.com/
- **MDN Web Docs**: https://developer.mozilla.org/
- **Google Fonts**: https://fonts.google.com/

---

**Last Updated**: November 3, 2025  
**Status**: ✅ Production Ready
