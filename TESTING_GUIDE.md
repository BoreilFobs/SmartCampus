# SmartCampus - Testing & Verification Guide

## 🧪 Testing Checklist

### Pre-Testing Setup
```bash
# 1. Install dependencies (if not done)
npm install

# 2. Build assets
npm run build

# 3. Start Laravel server
php artisan serve
```

---

## 1️⃣ Homepage Testing

### URL
```
http://localhost:8000/
```

### Visual Checks
- [ ] Hero section displays with purple gradient
- [ ] Gradient overlays visible
- [ ] "Transform Your Future Through Learning" heading visible
- [ ] Two buttons: "Explore Courses" and "Learn More"
- [ ] Stats section shows 4 cards with animated counters
- [ ] Level cards display from database
- [ ] Each level card has icon, title, description, stats
- [ ] Features section shows 6 cards
- [ ] CTA section at bottom with gradient
- [ ] Footer displays with 4 columns

### Functionality
- [ ] Click "Explore Courses" → scrolls to #levels
- [ ] Click "Learn More" → scrolls to #about
- [ ] Click any level card → navigates to level page
- [ ] Navbar links work (Home, Courses, About, Contact)
- [ ] Footer links work
- [ ] Back-to-top button appears after scrolling
- [ ] Smooth scrolling works

### Responsive
- [ ] Mobile view (< 768px) - hero image hidden, cards stack
- [ ] Tablet view (768px-992px) - 2 column grid
- [ ] Desktop view (> 992px) - 3 column grid

### SEO
- [ ] Right-click → View Page Source
- [ ] Verify `<title>` tag present
- [ ] Verify meta description present
- [ ] Verify Open Graph tags (og:title, og:description, etc.)
- [ ] Verify structured data (JSON-LD script)

---

## 2️⃣ Level Page Testing

### URL
```
http://localhost:8000/level/{level-slug}
```

### Visual Checks
- [ ] Gradient header with level name
- [ ] Breadcrumb: Home > Level Name
- [ ] Level description visible
- [ ] Search box centered below header
- [ ] Course cards in grid layout
- [ ] Each card shows: title, description, video count, duration
- [ ] "Start Learning" link with arrow icon

### Functionality
- [ ] Type in search box → courses filter in real-time
- [ ] Search for partial text → matches title or description
- [ ] Clear search → all courses appear
- [ ] No results → "No Courses Found" message appears
- [ ] Click course card → navigates to course page
- [ ] Breadcrumb "Home" link → returns to homepage
- [ ] Navbar still functional

### Responsive
- [ ] Mobile: 1 column grid
- [ ] Tablet: 2 column grid
- [ ] Desktop: 3 column grid
- [ ] Search box remains centered

### SEO
- [ ] Title: "{Level Name} Courses - SmartCampus"
- [ ] Description includes level description
- [ ] CollectionPage structured data present

---

## 3️⃣ Course Page Testing

### URL
```
http://localhost:8000/course/{course-slug}
```

### Visual Checks
- [ ] Gradient header with course title
- [ ] Breadcrumb: Home > Level > Course
- [ ] Video player visible (black background)
- [ ] Video info section below player
- [ ] Playlist sidebar on right (desktop) or below (mobile)
- [ ] Notes section below video info
- [ ] PDF download button (if PDF available)
- [ ] Previous/Next buttons visible

### Video Player
- [ ] Video loads correctly
- [ ] Native controls work (play, pause, volume, fullscreen)
- [ ] Video title displays above player
- [ ] Description updates when video changes

### Playlist Sidebar
- [ ] All videos listed with numbers
- [ ] Current video highlighted (gradient background)
- [ ] Click any video → video changes, notes update
- [ ] Hover effects work
- [ ] Scrollbar visible if many videos
- [ ] Custom scrollbar styling (purple thumb)

### Navigation
- [ ] Click "Next Video" → plays next video
- [ ] Click "Previous Video" → plays previous video
- [ ] Previous button disabled on first video
- [ ] Next button disabled on last video
- [ ] Press right arrow key → next video
- [ ] Press left arrow key → previous video
- [ ] Video ends → auto-plays next after 1 second

### Notes Section
- [ ] Notes display for current video
- [ ] Rich text formatting preserved (HTML)
- [ ] PDF button appears if PDF available
- [ ] Click PDF button → downloads file
- [ ] Notes update when video changes

### Responsive
- [ ] Desktop: Sidebar on right, video 8 columns
- [ ] Tablet/Mobile: Sidebar below video, full width
- [ ] Previous/Next buttons stack on mobile

### SEO
- [ ] Title: "{Course Title} - {Level Name} - SmartCampus"
- [ ] Description includes course description
- [ ] Course structured data present

---

## 4️⃣ Navigation Component Testing

### Desktop Navigation
- [ ] SmartCampus logo visible with icon
- [ ] Logo clickable → returns to home
- [ ] Nav links: Home, Courses, About, Contact
- [ ] Links have underline animation on hover
- [ ] Active page has yellow underline
- [ ] Auth state: Login button (if not logged in)
- [ ] Auth state: User dropdown (if logged in)
- [ ] Admin link visible (if user is admin)

### Mobile Navigation
- [ ] Hamburger menu appears (< 992px)
- [ ] Click hamburger → menu expands
- [ ] All links visible in expanded menu
- [ ] Click link → menu collapses, navigates

### Scroll Behavior
- [ ] Scroll down 50px → navbar gets shadow
- [ ] Navbar remains sticky at top
- [ ] Backdrop blur effect visible

---

## 5️⃣ Footer Component Testing

### Visual Checks
- [ ] Dark gradient background
- [ ] 4 columns: About, Quick Links, Categories, Contact
- [ ] SmartCampus logo in About section
- [ ] Social media icons (4 circular buttons)
- [ ] Quick links: Home, Courses, About, Contact
- [ ] Categories: First 4 levels from database
- [ ] Contact info with icons
- [ ] Copyright year: 2025
- [ ] Bottom links: Privacy, Terms, Sitemap

### Functionality
- [ ] Social icons have hover effects (purple gradient)
- [ ] Quick links navigate correctly
- [ ] Category links navigate to level pages
- [ ] Email/phone links work (mailto:, tel:)
- [ ] Footer links have hover effects

### Responsive
- [ ] Desktop: 4 columns side by side
- [ ] Tablet: 2x2 grid
- [ ] Mobile: Stacked vertically, centered text

---

## 6️⃣ Animations & Interactions

### Homepage
- [ ] Hero section has parallax scroll effect
- [ ] Stat numbers count up from 0
- [ ] Level cards fade in with stagger delay
- [ ] Feature cards animate on scroll
- [ ] Hover on level card → lifts and scales
- [ ] Hover on stat card → lifts with shadow

### Level Page
- [ ] Course cards fade in with stagger
- [ ] Hover on course → lifts
- [ ] Search has smooth filter transitions

### Course Page
- [ ] Playlist items have hover animation
- [ ] Active video has gradient background
- [ ] Click video → smooth content update
- [ ] Navigation buttons have hover lift
- [ ] Disabled buttons have reduced opacity

---

## 7️⃣ Performance Testing

### Page Load
- [ ] Homepage loads in < 2 seconds
- [ ] Images load progressively (lazy loading)
- [ ] No layout shift during load
- [ ] CSS loads before render (no FOUC)

### Animations
- [ ] All animations smooth at 60fps
- [ ] No janky scrolling
- [ ] Hover effects instantaneous

### Asset Sizes
```bash
# Check gzipped sizes
ls -lh public/build/assets/
```
- [ ] Total CSS < 20 KB
- [ ] Total JS < 100 KB
- [ ] All assets gzipped

---

## 8️⃣ SEO Validation

### Google Rich Results Test
1. Visit: https://search.google.com/test/rich-results
2. Enter homepage URL
3. Verify structured data detected

### Facebook Debugger
1. Visit: https://developers.facebook.com/tools/debug/
2. Enter homepage URL
3. Verify Open Graph tags present

### Manual Check
```bash
# View page source
curl http://localhost:8000/ | grep -E '<title>|<meta'
```

Expected tags:
- [ ] `<title>SmartCampus - Your Premier Online Learning Platform</title>`
- [ ] `<meta name="description" content="...">`
- [ ] `<meta property="og:title" content="...">`
- [ ] `<script type="application/ld+json">` (structured data)

---

## 9️⃣ Cross-Browser Testing

### Chrome
- [ ] All features work
- [ ] Animations smooth
- [ ] Video plays

### Firefox
- [ ] All features work
- [ ] Animations smooth
- [ ] Video plays

### Safari
- [ ] All features work
- [ ] Video plays with controls

### Edge
- [ ] All features work
- [ ] Animations smooth

---

## 🔟 Accessibility Testing

### Keyboard Navigation
- [ ] Tab through all interactive elements
- [ ] Focus indicators visible
- [ ] Enter activates buttons/links
- [ ] Arrow keys work in video player
- [ ] Escape closes dropdowns

### Screen Reader
- [ ] ARIA labels present where needed
- [ ] Images have alt attributes (structure ready)
- [ ] Headings in logical order (h1 → h2 → h3)
- [ ] Form labels associated with inputs

### Color Contrast
- [ ] Text readable on all backgrounds
- [ ] Buttons have sufficient contrast
- [ ] Links distinguishable

---

## 📱 Mobile Specific Testing

### iOS Safari
- [ ] Touch scrolling smooth
- [ ] Video player works
- [ ] Buttons tap-friendly (min 44px)
- [ ] No horizontal scroll
- [ ] Viewport meta tag working

### Android Chrome
- [ ] Touch scrolling smooth
- [ ] Video player works
- [ ] Buttons tap-friendly
- [ ] No horizontal scroll

### Orientation Changes
- [ ] Portrait → Landscape: layout adjusts
- [ ] No content overflow
- [ ] Navigation remains accessible

---

## 🐛 Known Issues to Check

### Potential Issues
1. **Video Path** - Ensure storage link created:
   ```bash
   php artisan storage:link
   ```

2. **Database** - Ensure seeded data exists:
   ```bash
   php artisan db:seed --class=LevelSeeder
   ```

3. **Assets** - If styles not loading:
   ```bash
   npm run build
   php artisan optimize:clear
   ```

4. **Routes** - If 404 errors:
   ```bash
   php artisan route:cache
   php artisan route:clear
   ```

---

## ✅ Final Verification

### Build Status
```bash
npm run build
# Should see:
# ✓ built in X.XXs
# No errors
```

### Routes Working
```bash
php artisan route:list --name=home
php artisan route:list --name=level.show
php artisan route:list --name=course.show
```

### Database Connected
```bash
php artisan tinker
>>> \App\Models\Level::count()
# Should return number > 0
```

---

## 🎯 Success Criteria

All tests pass when:
- ✅ All pages load without errors
- ✅ Navigation works across all pages
- ✅ SEO tags present on every page
- ✅ Responsive design works on all screen sizes
- ✅ Animations smooth and performant
- ✅ Video player functional
- ✅ Search filters courses correctly
- ✅ Keyboard navigation works
- ✅ Assets load and compile successfully

---

## 📊 Performance Benchmarks

Expected Results:
- **Lighthouse Performance:** 90+
- **First Contentful Paint:** < 1.5s
- **Time to Interactive:** < 3s
- **Cumulative Layout Shift:** < 0.1
- **Total Bundle Size:** < 150 KB (gzipped)

---

## 🚀 Deployment Checklist

Before deploying to production:
- [ ] Run all tests above
- [ ] Build assets: `npm run build`
- [ ] Optimize Laravel: `php artisan optimize`
- [ ] Set APP_ENV=production in .env
- [ ] Set APP_DEBUG=false in .env
- [ ] Configure real Open Graph images
- [ ] Set proper APP_URL
- [ ] Enable HTTPS
- [ ] Configure CDN (optional)
- [ ] Set up caching headers
- [ ] Enable gzip compression on server

---

**Testing Date:** November 2, 2025
**Status:** Ready for Testing
**Next Step:** Run through checklist systematically
