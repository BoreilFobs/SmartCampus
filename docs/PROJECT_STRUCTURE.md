# SmartCampus Project Structure

**Last Updated:** October 29, 2025

---

## 📁 Complete Project Structure

```
SmartCampus/
│
├── 📄 README.md                    # Project overview and setup guide
├── 📄 TODO.md                      # Detailed task breakdown and progress
├── 📄 composer.json                # PHP dependencies
├── 📄 package.json                 # Node.js dependencies
├── 📄 .env                         # Environment configuration
│
├── 📁 app/                         # Laravel application code
│   ├── Http/
│   │   ├── Controllers/            # Application controllers
│   │   ├── Middleware/             # Custom middleware
│   │   └── Requests/               # Form request validation
│   ├── Models/                     # Eloquent models
│   │   └── User.php                # ✅ Modified (is_admin column)
│   ├── Providers/                  # Service providers
│   └── View/
│       └── Components/             # Blade components
│
├── 📁 database/                    # Database related files
│   ├── factories/                  # Model factories
│   │   └── UserFactory.php
│   ├── migrations/                 # ✅ Database migrations
│   │   ├── 0001_01_01_000000_create_users_table.php
│   │   ├── 0001_01_01_000001_create_cache_table.php
│   │   ├── 0001_01_01_000002_create_jobs_table.php
│   │   ├── 2025_10_29_072930_create_levels_table.php      # ✅ NEW
│   │   ├── 2025_10_29_072937_create_courses_table.php     # ✅ NEW
│   │   ├── 2025_10_29_072938_create_videos_table.php      # ✅ NEW
│   │   ├── 2025_10_29_072939_create_notes_table.php       # ✅ NEW
│   │   └── 2025_10_29_073048_add_is_admin_to_users_table.php # ✅ NEW
│   ├── seeders/                    # Database seeders
│   │   └── DatabaseSeeder.php
│   └── database.sqlite             # SQLite database (dev)
│
├── 📁 docs/                        # ✅ Documentation (NEW)
│   ├── README.md                   # Documentation hub/index
│   ├── database/                   # Database documentation
│   │   └── DATABASE_SCHEMA.md      # Complete DB schema & ERD
│   └── completion-reports/         # Task completion reports
│       ├── PHASE1_TASK1_COMPLETED.md
│       ├── TASK1_VERIFICATION_REPORT.md
│       ├── TASK1_QUICK_REFERENCE.md
│       └── TASK1_COMPLETION_SUMMARY.txt
│
├── 📁 public/                      # Public web root
│   ├── index.php                   # Entry point
│   └── (future: videos, images via storage link)
│
├── 📁 resources/                   # Frontend resources
│   ├── css/
│   │   └── app.css                 # Tailwind CSS
│   ├── js/
│   │   ├── app.js                  # Main JS entry
│   │   └── bootstrap.js            # Bootstrap JS
│   └── views/                      # Blade templates
│       ├── welcome.blade.php
│       ├── dashboard.blade.php
│       ├── auth/                   # Authentication views
│       ├── components/             # Reusable components
│       ├── layouts/                # Layout templates
│       └── profile/
│
├── 📁 routes/                      # Application routes
│   ├── web.php                     # Web routes
│   ├── auth.php                    # Auth routes
│   └── console.php                 # Console commands
│
├── 📁 storage/                     # Application storage
│   ├── app/
│   │   ├── public/                 # Publicly accessible files
│   │   │   ├── videos/             # 🎥 Video files (VPS storage)
│   │   │   │   └── {course_id}/    # Organized by course
│   │   │   ├── thumbnails/
│   │   │   │   ├── courses/        # Course cover images
│   │   │   │   └── videos/         # Auto-generated thumbnails
│   │   │   └── notes/              # PDF summaries
│   │   └── private/                # Private files
│   ├── framework/                  # Framework cache
│   └── logs/                       # Application logs
│       └── laravel.log
│
├── 📁 tests/                       # Test suite
│   ├── Feature/                    # Feature tests
│   ├── Unit/                       # Unit tests
│   └── Pest.php
│
├── 📁 config/                      # Configuration files
├── 📁 bootstrap/                   # Bootstrap files
└── 📁 vendor/                      # Composer dependencies
```

---

## 📊 Key Directories Explained

### Application Code (`app/`)
- **Models:** Eloquent ORM models (upcoming: Level, Course, Video, Note)
- **Controllers:** Handle HTTP requests and responses
- **Middleware:** Request filtering (upcoming: AdminMiddleware)
- **Requests:** Form validation rules

### Database (`database/`)
- **migrations:** ✅ 5 custom migrations created
- **seeders:** Sample data generators (upcoming)
- **factories:** Model factories for testing

### Documentation (`docs/`) ✅ NEW
- **README.md:** Central documentation hub
- **database/:** Database schema and design docs
- **completion-reports/:** Task completion summaries

### Resources (`resources/`)
- **views:** Blade templates for UI
- **css:** Tailwind CSS styling
- **js:** Frontend JavaScript

### Storage (`storage/`)
- **app/public/videos:** VPS video storage (organized by course)
- **app/public/thumbnails:** Auto-generated thumbnails
- **app/public/notes:** Downloadable PDF files

### Routes (`routes/`)
- **web.php:** Public and admin web routes
- **auth.php:** Authentication routes

---

## 📝 File Status Legend

- ✅ **NEW** - Recently created
- ✅ **MODIFIED** - Updated from original
- 📄 **STANDARD** - Laravel default files
- 🎥 **VPS STORAGE** - Video storage location

---

## 🗂️ Documentation Navigation

### Quick Access:
- **Project Overview:** [README.md](../README.md)
- **Task Planning:** [TODO.md](../TODO.md)
- **Documentation Hub:** [docs/README.md](README.md)
- **Database Schema:** [docs/database/DATABASE_SCHEMA.md](database/DATABASE_SCHEMA.md)
- **Phase 1 Progress:** [docs/completion-reports/](completion-reports/)

---

## 📈 Current Status

### Completed:
- ✅ Project structure setup
- ✅ Database migrations (5 custom tables)
- ✅ Documentation organized
- ✅ VPS storage paths defined

### In Progress:
- 🔄 Models and relationships (next task)

### Upcoming:
- ⏳ Database seeders
- ⏳ Admin authentication
- ⏳ Controllers and routes
- ⏳ Blade views and components

---

## 🎯 Development Workflow

1. **Planning:** Check [TODO.md](../TODO.md)
2. **Implementation:** Work in `app/`, `database/`, `resources/`
3. **Testing:** Run tests in `tests/`
4. **Documentation:** Update `docs/`
5. **Commit:** Version control with Git

---

**Maintained By:** SmartCampus Development Team  
**Last Updated:** October 29, 2025
