# Level Seeder - Quick Reference Guide

## Overview
The LevelSeeder populates the `levels` table with the three main academic levels for SmartCampus.

## Seeded Levels

| ID | Name      | Slug      | Order | Status |
|----|-----------|-----------|-------|--------|
| 1  | HND 1     | hnd-1     | 1     | Active |
| 2  | HND 2     | hnd-2     | 2     | Active |
| 3  | Bachelor  | bachelor  | 3     | Active |

## Usage

### Run Level Seeder Only
```bash
php artisan db:seed --class=LevelSeeder
```

### Run All Seeders
```bash
php artisan db:seed
```

### Fresh Migration + Seeding
```bash
php artisan migrate:fresh --seed
```

### Reset and Reseed
```bash
php artisan migrate:refresh --seed
```

## Accessing Seeded Data

### In Tinker
```php
// Get all levels
$levels = App\Models\Level::all();

// Get specific level by ID
$hnd1 = App\Models\Level::find(1);

// Get by slug
$bachelor = App\Models\Level::where('slug', 'bachelor')->first();

// Get active levels in order
$active = App\Models\Level::active()->ordered()->get();
```

### In Controllers
```php
use App\Models\Level;

// List all levels
$levels = Level::ordered()->get();

// Get level with courses
$level = Level::with('courses')->find(1);

// Get active levels only
$activeLevels = Level::active()->ordered()->get();
```

### In Blade Views
```blade
@foreach(App\Models\Level::active()->ordered()->get() as $level)
    <h2>{{ $level->formatted_name }}</h2>
    <p>{{ $level->description }}</p>
    <span>Courses: {{ $level->courses_count }}</span>
@endforeach
```

## Level Data Details

### HND 1
- **Full Name:** Higher National Diploma Year 1
- **Purpose:** Foundation year with fundamental concepts
- **Target:** First-year HND students
- **URL Route:** `/levels/hnd-1`

### HND 2
- **Full Name:** Higher National Diploma Year 2
- **Purpose:** Advanced year building on HND 1
- **Target:** Second-year HND students
- **URL Route:** `/levels/hnd-2`

### Bachelor
- **Full Name:** Bachelor's Degree Program
- **Purpose:** Comprehensive undergraduate program
- **Target:** Bachelor's degree students
- **URL Route:** `/levels/bachelor`

## Model Features Available

### Relationships
```php
$level = Level::find(1);
$level->courses;              // All courses
$level->activeCourses;        // Only active courses
```

### Scopes
```php
Level::active()->get();       // Active levels only
Level::ordered()->get();      // Ordered by 'order' field
```

### Accessors
```php
$level->formatted_name;          // Uppercase name
$level->courses_count;           // Total courses
$level->active_courses_count;    // Active courses only
```

### Route Binding
```php
// In routes/web.php
Route::get('/levels/{level:slug}', function (Level $level) {
    return view('levels.show', compact('level'));
});

// Access via: /levels/hnd-1
```

## Testing Commands

### Verify Seeded Data
```bash
php artisan tinker --execute="
    \$levels = App\Models\Level::all();
    echo 'Total Levels: ' . \$levels->count() . PHP_EOL;
    \$levels->each(fn(\$l) => echo \$l->name . ' (Order: ' . \$l->order . ')' . PHP_EOL);
"
```

### Check Model Features
```bash
php artisan tinker --execute="
    \$level = App\Models\Level::first();
    echo 'Name: ' . \$level->name . PHP_EOL;
    echo 'Formatted: ' . \$level->formatted_name . PHP_EOL;
    echo 'Courses: ' . \$level->courses_count . PHP_EOL;
"
```

## Admin User Created

The DatabaseSeeder also creates a default admin user:

**Email:** admin@smartcampus.com  
**Password:** password (default - change in production!)  
**Admin Status:** Yes

## Next Steps

After Level Seeder:
1. ✅ Create CourseSeeder (reference level IDs 1, 2, 3)
2. ✅ Create VideoSeeder (reference course IDs)
3. ✅ Create NoteSeeder (reference video IDs)
4. ✅ Build admin dashboard to manage levels

## Troubleshooting

### Issue: Duplicate levels after seeding
**Solution:** The seeder clears existing levels. Comment out this line if you want to preserve data:
```php
// Level::query()->delete();
```

### Issue: Foreign key constraint errors
**Solution:** Run migrations fresh before seeding:
```bash
php artisan migrate:fresh --seed
```

### Issue: Levels not showing in order
**Solution:** Use the `ordered()` scope:
```php
Level::ordered()->get();
```

## File Locations

- **Seeder:** `database/seeders/LevelSeeder.php`
- **Model:** `app/Models/Level.php`
- **Migration:** `database/migrations/2025_10_29_072930_create_levels_table.php`
- **Documentation:** `docs/completion-reports/TASK_3_LEVEL_SEEDER_COMPLETION.md`

---

**Last Updated:** October 29, 2025  
**Status:** Production Ready ✅
