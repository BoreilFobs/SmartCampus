# SmartCampus - Troubleshooting Guide

## 🚨 Common Issues & Solutions

### Issue: "Page Not Found" (404 Error)

**Symptoms**: Routes not working, `GET /level/...` returns 404

**Causes & Solutions**:
1. **Route Cache Issue**
   ```bash
   php artisan route:clear
   php artisan route:cache
   ```

2. **Model Doesn't Exist**
   - Check if record exists in database
   - Verify slug is correct (URL-encoded)
   - Try: `Level::where('slug', 'your-slug')->first();`

3. **Model Binding Not Working**
   - Verify route uses `{level:slug}` or `{course:slug}`
   - Check if model has `getRouteKeyName()` method returning correct column
   - Default is 'id', should be 'slug'

**Test Route**:
```bash
# In terminal
php artisan tinker
Level::first() # Check if records exist
Level::first()->slug # Check slug format
```

---

### Issue: Sidebar/Tabs Not Showing

**Symptoms**: Mobile tabs appear on desktop, or sidebar shows on mobile

**Causes & Solutions**:

1. **Bootstrap CDN Not Loading**
   ```html
   <!-- Check browser console for CDN errors -->
   <!-- Make sure internet connection works -->
   <!-- Refresh browser cache (Ctrl+Shift+R) -->
   ```

2. **CSS Classes Wrong**
   - Check: `d-none d-lg-block` (sidebar should have this)
   - Check: `d-lg-none` (mobile tabs should have this)
   - Bootstrap version 5.3.0 is required

3. **Browser DevTools**
   ```javascript
   // In browser console
   getComputedStyle(document.querySelector('.sidebar')).display
   // Should be 'block' on desktop, 'none' on mobile
   ```

**Solution**: Hard refresh browser cache
```bash
# Or clear Laravel views
php artisan view:clear
```

---

### Issue: Videos Not Playing

**Symptoms**: Video player shows but no video plays

**Causes & Solutions**:

1. **Video File Path Wrong**
   ```blade
   <!-- Check if video URL is correct -->
   <video src="{{ $video->video_url }}"></video>
   
   <!-- Debug: Print video URL -->
   @dump($video->video_url)
   ```

2. **Video File Missing**
   - Check if file exists in storage
   - Verify path is accessible (permission issues?)
   ```bash
   # Check file exists
   ls -la storage/app/videos/
   
   # Check permissions
   chmod -R 755 storage/app/videos/
   ```

3. **CORS/Security Issue**
   - Videos on different domain?
   - Add CORS headers to `.htaccess` or middleware
   - Test with simple local video first

4. **Browser Doesn't Support Format**
   - Ensure `.mp4` format (most compatible)
   - Check browser console for error message
   - Try different browser

**Test**:
```bash
# In Tinker
Video::first()->video_url
# Should return valid URL/path

# Or check database directly
sqlite3 database/database.sqlite "SELECT id, title, video_url FROM videos LIMIT 1;"
```

---

### Issue: Search Not Working on Level Pages

**Symptoms**: Typing in search box doesn't filter courses

**Causes & Solutions**:

1. **JavaScript Error**
   ```javascript
   // In browser console, check for errors
   // Look for red messages
   ```

2. **HTML IDs Missing**
   - Course cards need `data-title` attribute
   - Search input needs `id="courseSearch"`
   ```blade
   <!-- Each course should have -->
   <div class="course-item" data-title="{{ strtolower($course->title) }}">
   
   <!-- Search input should have -->
   <input id="courseSearch" type="text" />
   ```

3. **JavaScript Not Running**
   ```javascript
   // In browser console, try manually
   document.getElementById('courseSearch').addEventListener('keyup', function() {
       console.log('Search triggered');
   });
   ```

**Debug Template**:
```blade
<!-- Check if JavaScript runs -->
<script>
  console.log('Page loaded');
  console.log('Courses found:', document.querySelectorAll('.course-item').length);
</script>
```

---

### Issue: Database Not Loading Data

**Symptoms**: Pages load but show empty grids, no courses/videos display

**Causes & Solutions**:

1. **Database Migration Issue**
   ```bash
   # Check if tables exist
   sqlite3 database/database.sqlite ".tables"
   # Should show: levels, courses, videos, notes, users, etc.
   ```

2. **No Data/Seeds Issue**
   ```bash
   # Run seeders
   php artisan db:seed
   
   # Or specific seeder
   php artisan db:seed --class=LevelSeeder
   ```

3. **Controller Not Passing Data**
   ```php
   // In HomeController@index, check:
   return view('welcome', [
       'levels' => Level::where('is_active', true)->with('courses')->get(),
       'totalCourses' => Course::count(),
       // ... other data
   ]);
   ```

4. **View Not Accessing Data**
   ```blade
   <!-- Debug: Check if data exists -->
   @dump($levels)
   @dump($courses)
   
   <!-- Or check with conditional -->
   @if(isset($levels))
       @foreach($levels as $level)
           {{ $level->title }}
       @endforeach
   @else
       <p>No levels found</p>
   @endif
   ```

**Debug Database**:
```bash
php artisan tinker
Level::count()                    # Should be > 0
Course::count()                   # Should be > 0
Video::count()                    # Should be > 0
Level::with('courses.videos')->first()  # Check relationships
```

---

### Issue: Styling Not Loading/Looking Wrong

**Symptoms**: Page looks plain, no colors, wrong layout, Bootstrap classes not working

**Causes & Solutions**:

1. **CDN Not Loading**
   ```html
   <!-- Check browser Network tab for Bootstrap CDN -->
   <!-- Should show 200 status, not 404 -->
   
   <!-- Fallback: Use local Bootstrap -->
   <!-- Instead of CDN, install: npm install bootstrap -->
   ```

2. **CSS Cascade Issue**
   - Inline styles override class styles
   - Check DevTools for conflicting CSS
   - Ensure custom CSS comes after Bootstrap CSS

3. **Responsive Breakpoints Wrong**
   ```javascript
   // In console, check window width
   console.log(window.innerWidth);
   
   // Should match Bootstrap breakpoints:
   // sm: 576px, md: 768px, lg: 992px, xl: 1200px
   ```

4. **Cache Not Cleared**
   ```bash
   php artisan view:clear
   php artisan cache:clear
   php artisan config:clear
   ```

**Verify CSS Loading**:
```javascript
// In browser console
window.getComputedStyle(document.body).fontFamily
// Should include 'Poppins'

window.getComputedStyle(document.querySelector('.btn-primary')).backgroundColor
// Should show gradient color
```

---

### Issue: Animations Not Showing

**Symptoms**: Smooth fade-in effects missing, pages feel choppy

**Causes & Solutions**:

1. **CSS Animations Disabled**
   ```css
   /* Check if animations are set in CSS */
   @keyframes fadeInUp {
       from { opacity: 0; transform: translateY(20px); }
       to { opacity: 1; transform: translateY(0); }
   }
   ```

2. **Elements Not Getting Animation Class**
   ```blade
   <!-- Elements need data-animate attribute -->
   <div data-animate="fade-in-up">Content</div>
   ```

3. **IntersectionObserver Not Working**
   ```javascript
   // In console, check if supported
   'IntersectionObserver' in window
   // Should return true
   ```

4. **Browser GPU Acceleration Issue**
   - Close other apps/tabs
   - Update browser
   - Check browser settings

**Enable Animations**:
```html
<!-- Add to page to test -->
<script>
  const observer = new IntersectionObserver((entries) => {
      entries.forEach(entry => {
          if (entry.isIntersecting) {
              entry.target.classList.add('fade-in-up');
          }
      });
  });
  
  document.querySelectorAll('[data-animate]').forEach(el => {
      observer.observe(el);
  });
</script>
```

---

### Issue: Mobile Layout Broken

**Symptoms**: Mobile view shows desktop content, text too large/small, unclickable buttons

**Causes & Solutions**:

1. **Viewport Meta Tag Missing**
   ```html
   <!-- Should be in <head> -->
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   ```

2. **Wrong Bootstrap Classes**
   ```blade
   <!-- Wrong -->
   <div class="col-12">Full width</div>
   
   <!-- Right -->
   <div class="col-12 col-md-6 col-lg-4">
       Mobile: 1 col, Tablet: 2 col, Desktop: 4 col
   </div>
   ```

3. **Touch Target Too Small**
   - Buttons should be at least 44x44px
   - Links should have padding
   ```css
   .btn { min-height: 44px; min-width: 44px; }
   a { padding: 0.5rem; }
   ```

4. **Overflow on Mobile**
   ```css
   body { overflow-x: hidden; }
   ```

**Test Mobile**:
```javascript
// In browser console
// Open DevTools, click device icon for responsive view
// Test at 375px (iPhone), 768px (iPad), 1024px (laptop)
```

---

### Issue: Server Not Starting

**Symptoms**: `php artisan serve` fails, "Address already in use" or other errors

**Causes & Solutions**:

1. **Port Already in Use**
   ```bash
   # Check what's using port 8000
   lsof -i :8000
   
   # Use different port
   php artisan serve --port=8080
   
   # Or kill the process
   kill -9 <PID>
   ```

2. **PHP Not Installed**
   ```bash
   php -v
   # Should show PHP version
   ```

3. **Laravel Files Issue**
   ```bash
   # Regenerate app key
   php artisan key:generate
   
   # Clear cache
   php artisan cache:clear
   php artisan config:clear
   ```

4. **Permission Issue**
   ```bash
   # Fix permissions
   chmod -R 755 bootstrap/cache
   chmod -R 755 storage
   ```

**Start Server**:
```bash
# Basic
php artisan serve

# With specific port
php artisan serve --port=8080

# Show full output
php artisan serve --verbose

# Accessible from other machines
php artisan serve --host=0.0.0.0 --port=8080
```

---

### Issue: "Class Not Found" Errors

**Symptoms**: PHP errors like "Class 'App\Models\Level' not found"

**Causes & Solutions**:

1. **Autoload Not Regenerated**
   ```bash
   composer dump-autoload
   composer autoload
   ```

2. **Model File Doesn't Exist**
   ```bash
   # Check if file exists
   ls app/Models/Level.php
   
   # Create if missing
   php artisan make:model Level
   ```

3. **Namespace Wrong**
   ```php
   // Should be at top of controller
   namespace App\Http\Controllers;
   use App\Models\Level;
   ```

4. **Migration Not Ran**
   ```bash
   php artisan migrate
   php artisan migrate:fresh --seed
   ```

---

### Issue: Keyboard Shortcuts Not Working

**Symptoms**: Arrow keys don't navigate video, Space doesn't pause

**Causes & Solutions**:

1. **Focus Not on Video**
   ```javascript
   // Click video player first, then try keys
   // Or check if focus is on another element
   document.activeElement  // Check in console
   ```

2. **JavaScript Error**
   ```javascript
   // Check browser console for errors
   // Look for red messages in DevTools
   ```

3. **Event Listener Not Attached**
   ```javascript
   // In console, try manually
   document.addEventListener('keydown', function(e) {
       console.log('Key pressed:', e.key);
   });
   ```

**Debug Keyboard**:
```javascript
// Add to page to test
<script>
  document.addEventListener('keydown', function(e) {
      console.log('Key:', e.key, 'Code:', e.code);
  });
</script>
```

---

## 🔧 General Debug Tips

### Check Browser Console
```javascript
// Press F12, click Console tab
// Look for red errors
// Try typing to test JavaScript is working
```

### Check Network Tab
```
Press F12 → Network tab
Reload page
Look for red items (failed requests)
Check CDN requests loaded with 200 status
```

### Check Elements Inspector
```
Press F12 → Elements tab
Right-click element → Inspect
Check computed CSS
Look for what style is applied
```

### Check Storage
```
Press F12 → Storage/Application tab
Check Cookies, Local Storage, Session Storage
Look for app data
```

### Clear Cache Completely
```bash
# All caches
php artisan optimize:clear
php artisan config:cache

# Or full reset
rm -rf bootstrap/cache/*
php artisan cache:clear
php artisan view:clear
```

### Enable Debug Mode
```bash
# In .env file
APP_DEBUG=true

# Then errors show full stack trace
```

### Check Logs
```bash
# Real-time logs
tail -f storage/logs/laravel.log

# Or check latest errors
cat storage/logs/laravel.log | tail -50
```

---

## 📞 When to Contact Support

If you encounter issues not listed here:

1. **Collect Information**:
   - Error message (exact text)
   - Browser console errors
   - Steps to reproduce
   - Screenshot
   - Laravel log errors

2. **Check Documentation**:
   - DEVELOPER_QUICK_REFERENCE.md
   - TASKS_10_11_12_COMPLETION.md
   - VISUAL_GUIDE_RESPONSIVE_DESIGN.md

3. **Provide Details**:
   - PHP version: `php -v`
   - Laravel version: `php artisan --version`
   - Database type: SQLite/MySQL/PostgreSQL
   - Browser version

---

**Last Updated**: November 3, 2025  
**Status**: Complete
