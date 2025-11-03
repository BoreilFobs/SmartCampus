# SmartCampus - Quick Reference Card

## 🚀 Getting Started

### Start Development Server
```bash
npm run dev          # Vite dev server with hot reload
php artisan serve    # Laravel server (different terminal)
```

### Build for Production
```bash
npm run build        # Compile and minify assets
php artisan optimize # Optimize Laravel
```

---

## 📁 File Locations

### Layouts & Components
```
resources/views/layouts/app.blade.php          # Main layout
resources/views/components/navigation.blade.php # Navbar
resources/views/components/footer.blade.php     # Footer
```

### Views
```
resources/views/welcome.blade.php              # Homepage
resources/views/levels/show.blade.php          # Level list page
resources/views/courses/show.blade.php         # Course detail page
```

### Styles
```
resources/css/app.css     # Global styles
resources/css/home.css    # Homepage styles
resources/css/level.css   # Level page styles
resources/css/course.css  # Course page styles
```

### Scripts
```
resources/js/app.js       # Global JavaScript
resources/js/home.js      # Homepage JavaScript
```

### Configuration
```
vite.config.js            # Asset bundling config
```

---

## 🎨 Using the Layout System

### Basic Page Template
```blade
@extends('layouts.app')

@section('title', 'Your Page Title')
@section('description', 'Your page description for SEO')
@section('keywords', 'keyword1, keyword2, keyword3')

@push('styles')
    @vite(['resources/css/your-style.css'])
@endpush

@section('content')
    <!-- Your page content here -->
@endsection

@push('scripts')
    @vite(['resources/js/your-script.js'])
@endpush
```

### SEO Meta Tags
```blade
@section('title', 'Page Title - SmartCampus')
@section('description', 'Page description here')
@section('keywords', 'keywords, here')
@section('og_title', 'Social sharing title')
@section('og_description', 'Social sharing description')
@section('og_image', asset('path/to/image.jpg'))
```

### Structured Data
```blade
@push('structured-data')
<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "WebPage",
    "name": "Your Page Name"
}
</script>
@endpush
```

---

## 🎯 Component Usage

### Navigation
```blade
{{-- Automatically included in layout --}}
<x-navigation />
```

### Footer
```blade
{{-- Automatically included in layout --}}
<x-footer />
```

---

## 💅 CSS Classes Reference

### Layout
```css
.container           /* Bootstrap container */
.row                /* Bootstrap row */
.col-lg-6          /* Responsive column */
```

### Components
```css
.card               /* Card component */
.btn                /* Button base */
.btn-primary        /* Primary button with gradient */
```

### Utilities
```css
.shadow-sm          /* Small shadow */
.shadow-md          /* Medium shadow */
.shadow-lg          /* Large shadow */
.rounded-lg         /* 12px border radius */
.transition-all     /* Smooth transitions */
```

### Custom Classes
```css
.hero-section       /* Hero with gradient */
.stat-card          /* Statistics card */
.level-card         /* Level card with hover */
.course-card        /* Course card */
.video-container    /* Video player wrapper */
.playlist-sidebar   /* Video playlist */
```

---

## 🎭 Animations

### Available Animations
```css
.animate-fadeInUp   /* Fade in from bottom */
.animate-fadeIn     /* Simple fade in */
.animate-float      /* Floating animation */
```

### Using Animations
```blade
<div class="animate-fadeInUp" style="animation-delay: 0.2s;">
    Content here
</div>
```

---

## ⚡ JavaScript Utilities

### Global Functions
```javascript
// Show toast notification
SmartCampus.showToast('Message here', 'success');

// Format number
SmartCampus.formatNumber(1234);  // "1,234"

// Format duration
SmartCampus.formatDuration(125); // "2:05"

// Debounce function
SmartCampus.debounce(function() { ... }, 300);
```

---

## 🔍 Common Tasks

### Add New Page
1. Create view file in `resources/views/`
2. Extend `layouts.app`
3. Define SEO sections
4. Create route in `routes/web.php`
5. Create controller if needed

### Add Page-Specific CSS
1. Create CSS file in `resources/css/`
2. Add to `vite.config.js` inputs array
3. Use `@vite(['resources/css/your-file.css'])` in view
4. Run `npm run build`

### Add Page-Specific JS
1. Create JS file in `resources/js/`
2. Add to `vite.config.js` inputs array
3. Use `@vite(['resources/js/your-file.js'])` in view
4. Run `npm run build`

---

## 🐛 Troubleshooting

### Assets Not Loading
```bash
npm run build
php artisan optimize:clear
```

### Styles Not Updating
```bash
npm run dev  # Use dev mode for hot reload
```

### Routes Not Working
```bash
php artisan route:clear
php artisan route:cache
```

### Database Issues
```bash
php artisan migrate:fresh --seed
php artisan storage:link
```

---

## 📊 Build Commands

```bash
# Development (hot reload)
npm run dev

# Production build (minified)
npm run build

# Watch mode (rebuild on change)
npm run watch

# Check build output
ls -lh public/build/assets/
```

---

## 🌐 URLs

### Public Pages
```
/                    # Homepage
/level/{slug}        # Level list
/course/{slug}       # Course detail
```

### Admin Pages (requires auth + admin)
```
/admin/dashboard     # Admin dashboard
/admin/courses       # Course management
/admin/videos        # Video management
/admin/notes         # Notes management
/admin/levels        # Level management
```

---

## 🎨 Color Variables

```css
var(--primary-gradient)    /* Purple gradient */
var(--primary-color)       /* #667eea */
var(--secondary-color)     /* #ffc107 */
var(--text-dark)           /* #1a1a2e */
var(--text-gray)           /* #6c757d */
var(--bg-light)            /* #f8f9fa */
```

---

## 📱 Responsive Breakpoints

```css
/* Mobile First */
@media (min-width: 576px)  { /* Tablet */ }
@media (min-width: 768px)  { /* Desktop */ }
@media (min-width: 992px)  { /* Large */ }
@media (min-width: 1200px) { /* XL */ }
```

---

## ✅ Pre-Deployment Checklist

```
□ Run npm run build
□ Test all pages
□ Verify SEO tags
□ Test mobile responsiveness
□ Check console for errors
□ Optimize images
□ Enable caching
□ Set APP_ENV=production
□ Set APP_DEBUG=false
□ Configure APP_URL
```

---

## 📚 Documentation

- **IMPLEMENTATION_COMPLETE.md** - Full implementation summary
- **ENHANCEMENT_SUMMARY.md** - Quick reference
- **TESTING_GUIDE.md** - Testing checklist
- **ARCHITECTURE_OVERVIEW.md** - System architecture
- **THIS FILE** - Quick reference card

---

## 🆘 Quick Help

### Common Issues

**Problem:** Vite not found
```bash
npm install
```

**Problem:** Permission denied
```bash
chmod -R 755 storage bootstrap/cache
```

**Problem:** Class not found
```bash
composer dump-autoload
```

**Problem:** 404 on routes
```bash
php artisan route:clear
```

---

## 📞 Support

- Check documentation files
- Review TODO.md for project status
- See TESTING_GUIDE.md for verification steps
- Consult ARCHITECTURE_OVERVIEW.md for system design

---

**Version:** 1.0
**Last Updated:** November 2, 2025
**Status:** Production Ready ✅
