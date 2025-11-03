# SmartCampus - Quick Start Guide (5 Minutes)

## ⚡ Get Started in 5 Steps

### Step 1: Start the Server (30 seconds)

```bash
# Navigate to project
cd /home/fobs/Desktop/Projects/SmartCampus

# Start Laravel development server
php artisan serve --port=8080
```

**Expected Output**:
```
   INFO  Server running on http://127.0.0.1:8080
```

✅ Server is running!

---

### Step 2: Open in Browser (15 seconds)

Click the link or open: **http://localhost:8080**

**You should see**:
- Homepage with purple gradient background
- Academic levels displayed in a grid
- "Explore Courses" buttons
- Statistics cards at the top

✅ Homepage loaded!

---

### Step 3: Explore on Mobile (30 seconds)

1. Press `F12` to open DevTools
2. Click the **device icon** (top left of DevTools)
3. Select **iPhone 12** or any mobile device

**You should see**:
- Mobile tabs at the bottom (instead of sidebar)
- Single column layout
- Responsive design adapts perfectly

✅ Mobile view working!

---

### Step 4: Browse Courses (1 minute)

1. On **desktop**: Click a level in the sidebar OR on the grid
2. On **mobile**: Tap a level card

**Level page should show**:
- Level name and statistics
- Search box at the top
- Grid of courses with thumbnails
- "Back to Home" link

✅ Level pages working!

---

### Step 5: Watch a Video (2 minutes)

1. Click any course card to enter

**Course page should show**:
- Large video player (top/left on desktop)
- Playlist on the right (desktop) or below (mobile)
- Video title and description
- "Next" and "Previous" buttons

**Try**:
- Click different videos in playlist to play them
- Use Arrow keys to navigate (Right = next, Left = previous)
- Press Space to play/pause

✅ Video player working!

---

## 🎯 What You Have

### 3 Main Pages
✅ **Homepage** - Browse all academic levels
✅ **Level Pages** - Browse courses by level with search
✅ **Course Pages** - Watch videos with playlist

### 3 Key Features
✅ **Responsive Design** - Sidebar on desktop, tabs on mobile
✅ **Bootstrap Styling** - Professional look with animations
✅ **Smooth Navigation** - Easy flow between pages

### 3 Technologies
✅ **Bootstrap 5** - CSS framework
✅ **Laravel 10** - Backend framework
✅ **HTML5 Video** - Native video player

---

## 📱 Responsive Breakpoints

### Mobile (< 768px)
- Single column layout
- Bottom navigation tabs
- Stacked video/playlist
- Touch-friendly buttons

### Tablet (768px - 991px)
- 2-column grid for courses
- Side-by-side layout forming
- Tabs still visible

### Desktop (≥ 992px)
- 3-column grid for courses
- Fixed left sidebar navigation
- Tabs hidden
- Full side-by-side video/playlist

**Test all sizes**: Press `F12` → Resize window → Check layout adapts

---

## 🎨 Design Elements

### Colors
- 🟣 **Primary**: Purple gradient (`#667eea → #764ba2`)
- 🟠 **Secondary**: Dark background (`#1a1a2e`)
- 🟡 **Accent**: Gold highlights (`#ffc107`)

### Typography
- Font: **Poppins** (modern, clean)
- Sizes: Responsive (smaller on mobile)
- Weight: Bold headings, regular body text

### Components
- Cards: Rounded corners, subtle shadows
- Buttons: Gradient, hover effects
- Navigation: Fixed sidebar/tabs, sticky navbar
- Animations: Smooth fade-in effects

---

## 🚀 Common Tasks

### Change a Level Name (in Admin)
1. Go to admin panel
2. Click Settings → Academic Levels
3. Edit the level
4. Save
5. Homepage automatically updates ✅

### Add a New Course (in Admin)
1. Go to admin panel
2. Click Content → Courses
3. Create new course
4. Upload thumbnail
5. Select level
6. Save
7. Course appears on level page ✅

### Upload a Video (in Admin)
1. Go to admin panel
2. Click Content → Videos
3. Create new video
4. Upload MP4 file
5. Select course
6. Save
7. Video appears in course player ✅

---

## 🔍 Check Database

### See All Levels
```bash
php artisan tinker
Level::all()
```

### See All Courses
```bash
Course::all()
```

### See Videos for a Course
```bash
Course::first()->videos
```

### See Full Course with Videos
```bash
Course::first()->load('videos')
```

---

## 🛠️ Useful Commands

```bash
# Start server (on different port if needed)
php artisan serve --port=8080

# Clear all caches
php artisan optimize:clear

# See database
sqlite3 database/database.sqlite ".tables"

# Run seeders (if database is empty)
php artisan db:seed

# View Laravel logs
tail -f storage/logs/laravel.log

# Access interactive shell
php artisan tinker
```

---

## 📚 Learn More

- **Developer Guide**: See `DEVELOPER_QUICK_REFERENCE.md`
- **Full Details**: See `TASKS_10_11_12_COMPLETION.md`
- **Troubleshooting**: See `TROUBLESHOOTING_GUIDE.md`
- **Visual Guide**: See `VISUAL_GUIDE_RESPONSIVE_DESIGN.md`

---

## ✅ Verification Checklist

After following the quick start, verify everything:

- [ ] Server starts without errors
- [ ] Homepage loads with levels
- [ ] Sidebar visible on desktop
- [ ] Mobile tabs visible on mobile
- [ ] Can click level to go to level page
- [ ] Search works on level page
- [ ] Can click course to view
- [ ] Video plays on course page
- [ ] Playlist switches videos
- [ ] Arrow keys navigate videos
- [ ] Responsive design works (resize browser)
- [ ] No errors in browser console (`F12` → Console)

**All checked?** ✅ You're ready to develop!

---

## 🎓 Learning Path (if new to the project)

**Day 1**: Get familiar
- [ ] Run through Quick Start above
- [ ] Explore each page in browser
- [ ] Check responsive design on mobile
- [ ] Read VISUAL_GUIDE_RESPONSIVE_DESIGN.md

**Day 2**: Understand the code
- [ ] Read DEVELOPER_QUICK_REFERENCE.md
- [ ] Look at `resources/views/layouts/app.blade.php`
- [ ] Check HomeController, LevelController, CourseController
- [ ] View routes in `routes/web.php`

**Day 3**: Start customizing
- [ ] Change colors in `app.blade.php`
- [ ] Add new features to pages
- [ ] Modify styling with CSS
- [ ] Add new routes if needed

---

## 🆘 If Something Breaks

1. **Check console errors**
   - Press `F12` in browser
   - Look for red error messages
   - Note the error text

2. **Check Laravel logs**
   ```bash
   tail -f storage/logs/laravel.log
   ```

3. **Clear cache**
   ```bash
   php artisan optimize:clear
   php artisan view:clear
   ```

4. **Restart server**
   ```bash
   # Press Ctrl+C to stop current server
   # Then start again
   php artisan serve --port=8080
   ```

5. **Check TROUBLESHOOTING_GUIDE.md** for specific issues

6. **Ask for help** - Provide:
   - The error message (exactly)
   - Steps to reproduce
   - Screenshot if possible
   - Browser/PHP version

---

## 🎉 You're All Set!

Everything is ready to use. The app is:
- ✅ Fully functional
- ✅ Responsive on all devices
- ✅ Bootstrap styled
- ✅ Database integrated
- ✅ Production-ready

**Next step**: Start the server and explore! 🚀

---

**Quick Start Version**: 1.0  
**Created**: November 3, 2025  
**Status**: ✅ Ready to Use
