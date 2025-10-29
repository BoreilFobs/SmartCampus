# 🎓 SmartCampus - Educational Video Platform

![Laravel](https://img.shields.io/badge/Laravel-11.x-red.svg)
![PHP](https://img.shields.io/badge/PHP-8.2+-blue.svg)
![License](https://img.shields.io/badge/License-MIT-green.svg)

**SmartCampus** is a simple, public educational platform designed to help students access quality learning materials through video lessons and concise study notes. Built with Laravel and Tailwind CSS, it provides an intuitive interface for browsing courses by academic level without requiring user registration.

---

## 🎯 Project Vision

Create a free, accessible learning platform where students pursuing HND (Higher National Diploma) and Bachelor's degrees can:
- Watch educational video content organized by academic level
- Access summarized notes and downloadable PDFs
- Learn at their own pace without barriers
- Access content from any device, especially mobile phones

**Target Audience:** HND1, HND2, and Bachelor students seeking supplementary learning resources.

---

## ✨ Key Features

### 🌐 Public Frontend (No Login Required)

#### 📱 **Homepage**
- Clean, welcoming interface introducing the platform
- Three prominent level cards: HND 1, HND 2, and Bachelor
- Mobile-first responsive design
- Quick navigation to any academic level

#### 📚 **Level Pages**
- Browse all courses available for selected level
- Course cards display:
  - Course thumbnail/icon
  - Course title and description
  - Number of available videos
- Search functionality to quickly find courses
- Filter by subject/category
- Responsive grid layout

#### 🎬 **Course Detail Pages**
- Embedded HTML5 video player for VPS-hosted videos
- Complete playlist of course videos
- Click any video to play instantly
- Study notes displayed below each video
- Downloadable PDF summaries
- Next/Previous video navigation
- Video duration and title display
- Playback speed controls (0.5x - 2x)
- Full-screen mode support

#### 📄 **Static Pages**
- **About Page:** Mission, vision, and platform goals
- **Contact Page:** Feedback form and support links

---

### 🔐 Admin Dashboard (Protected)

#### 📊 **Dashboard Overview**
- Statistics on total courses, videos, and notes
- Recent upload activity
- Quick action buttons

#### 🎓 **Course Management**
- Create, edit, and delete courses
- Assign courses to academic levels
- Upload course thumbnails
- Set course visibility (active/inactive)
- Drag-and-drop course ordering

#### 🎥 **Video Management**
- Direct video upload to VPS server storage
- Support for large files with chunked upload
- Automatic video duration extraction (FFmpeg)
- Auto-generate video thumbnails
- Upload progress indicator
- Video file validation (MP4 format)
- Replace or delete uploaded videos
- Organize videos within courses
- Reorder video playlists (drag-and-drop)
- Video preview before publishing
- Storage usage tracking

#### 📝 **Notes Management**
- Rich text editor for creating study notes
- Upload PDF summaries for download
- Link notes to specific videos
- Preview notes before saving

#### � **Access Control**
- Admin-only authentication system
- Protected admin routes and dashboard
- Role-based permissions
- **All content managed exclusively by administrators**

---

## 🛠️ Technology Stack

- **Backend:** Laravel 11.x
- **Frontend:** Blade Templates + Tailwind CSS
- **Database:** SQLite (development) / MySQL (production)
- **Authentication:** Laravel Breeze
- **File Storage:** VPS Local Storage (no S3/cloud)
- **Video Processing:** FFmpeg
- **Video Player:** Video.js / Plyr.io
- **Upload:** Chunked uploads for large files
- **Server:** Nginx/Apache on VPS
- **Testing:** Pest PHP

---

## 📁 Project Structure

```
SmartCampus/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── HomeController.php
│   │   │   ├── LevelController.php
│   │   │   ├── CourseController.php
│   │   │   └── Admin/
│   │   │       ├── DashboardController.php
│   │   │       ├── CourseController.php
│   │   │       ├── VideoController.php
│   │   │       └── NoteController.php
│   │   └── Middleware/
│   │       └── AdminMiddleware.php
│   ├── Models/
│   │   ├── Level.php
│   │   ├── Course.php
│   │   ├── Video.php
│   │   └── Note.php
│   └── View/
│       └── Components/
│           ├── LevelCard.php
│           ├── CourseCard.php
│           └── VideoPlayer.php
├── database/
│   ├── migrations/
│   │   ├── create_levels_table.php
│   │   ├── create_courses_table.php
│   │   ├── create_videos_table.php
│   │   └── create_notes_table.php
│   └── seeders/
│       ├── LevelSeeder.php
│       └── CourseSeeder.php
├── resources/
│   ├── views/
│   │   ├── welcome.blade.php
│   │   ├── levels/
│   │   │   └── show.blade.php
│   │   ├── courses/
│   │   │   └── show.blade.php
│   │   ├── admin/
│   │   │   ├── dashboard.blade.php
│   │   │   ├── courses/
│   │   │   └── videos/
│   │   └── components/
│   │       ├── level-card.blade.php
│   │       ├── course-card.blade.php
│   │       └── video-player.blade.php
│   └── css/
│       └── app.css (Tailwind)
├── routes/
│   ├── web.php
│   └── admin.php
└── storage/
    └── app/
        └── public/
            ├── videos/
            ├── thumbnails/
            └── notes/
```

---

## 🚀 Installation

### Prerequisites
- PHP 8.2 or higher
- Composer
- Node.js & NPM
- MySQL/MariaDB database
- FFmpeg (for video processing)
- VPS Server (for production deployment)

### Setup Steps

1. **Clone the repository**
```bash
git clone <repository-url>
cd SmartCampus
```

2. **Install PHP dependencies**
```bash
composer install
```

3. **Install NPM dependencies**
```bash
npm install
```

4. **Environment configuration**
```bash
cp .env.example .env
php artisan key:generate
```

5. **Configure database** (edit `.env`)
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=smartcampus
DB_USERNAME=root
DB_PASSWORD=your_password

# File upload limits
UPLOAD_MAX_FILESIZE=2048
POST_MAX_SIZE=2048
MAX_VIDEO_SIZE=2097152
```

6. **Run migrations and seeders**
```bash
php artisan migrate --seed
```

7. **Create storage symlink and set permissions**
```bash
php artisan storage:link
chmod -R 775 storage bootstrap/cache
```

8. **Install FFmpeg (for video processing)**
```bash
# Ubuntu/Debian
sudo apt-get install ffmpeg -y

# macOS
brew install ffmpeg
```

9. **Build frontend assets**
```bash
npm run dev
# Or for production:
npm run build
```

10. **Start development server**
```bash
php artisan serve
```

Visit `http://localhost:8000` in your browser.

---

## 👤 Default Admin Access

**Email:** admin@smartcampus.com  
**Password:** password

⚠️ **Important:** Change these credentials immediately after first login!

---

## 📖 Usage Guide

### For Students

1. Visit the homepage
2. Select your academic level (HND1, HND2, or Bachelor)
3. Browse available courses
4. Click a course to view videos and notes
5. Watch videos and download study materials

### For Administrators

1. Login at `/admin/login`
2. Navigate to **Courses** to create new courses
3. Upload videos directly to the server via **Videos** section
   - Select MP4 video files
   - System will extract duration and generate thumbnails
   - Monitor upload progress
4. Add study notes and PDF summaries for each video
5. Manage content visibility and ordering
6. Monitor storage usage in dashboard statistics

---

## 🎨 Features Roadmap

### ✅ Phase 1 (Current)
- [x] Basic database structure
- [x] Admin authentication
- [x] Course and video management
- [x] VPS video upload with chunked support
- [x] Public frontend with HTML5 video playback
- [x] FFmpeg integration for video processing

### 🚧 Phase 2 (Upcoming)
- [ ] User registration and login
- [ ] Watch progress tracking
- [ ] Bookmarking favorite courses
- [ ] Comments and discussion system
- [ ] Quiz and assessment module

### 🔮 Phase 3 (Future)
- [ ] Certificate generation
- [ ] Analytics dashboard (video views, popular courses)
- [ ] Multi-language support
- [ ] Video compression and optimization tools
- [ ] Automatic video transcoding
- [ ] Bandwidth usage monitoring
- [ ] Mobile apps (iOS/Android)

---

## 🧪 Testing

Run the test suite:
```bash
php artisan test
```

Run specific test:
```bash
php artisan test --filter=CourseTest
```

---

## 📝 API Documentation

Currently, this project focuses on web interface. All content management is done through the admin dashboard. API endpoints may be added in future versions for mobile app integration.

---

## 🤝 Contributing

Contributions are welcome! Please follow these steps:

1. Fork the repository
2. Create a feature branch (`git checkout -b feature/amazing-feature`)
3. Commit your changes (`git commit -m 'Add amazing feature'`)
4. Push to the branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request

---

## 🐛 Bug Reports

Found a bug? Please open an issue with:
- Description of the bug
- Steps to reproduce
- Expected vs actual behavior
- Screenshots (if applicable)

---

## 📄 License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

---

## 👥 Authors

**Development Team**
- Project Lead: [Your Name]
- Contributors: See [CONTRIBUTORS.md](CONTRIBUTORS.md)

---

## 🙏 Acknowledgments

- Laravel Framework
- Tailwind CSS
- Video.js
- All contributors and testers

---

## 📞 Support

- **Email:** support@smartcampus.com
- **Documentation:** [Wiki](https://github.com/your-repo/wiki)
- **Issues:** [GitHub Issues](https://github.com/your-repo/issues)

---

## 🌟 Screenshots

_Coming soon - screenshots of the platform in action_

---

**Built with ❤️ for students seeking accessible education**

---

## 📚 Additional Resources

### 📖 Documentation
- [Documentation Index](docs/README.md) - Complete documentation hub
- [Database Schema](docs/database/DATABASE_SCHEMA.md) - Database structure and ERD
- [Task Completion Reports](docs/completion-reports/) - Phase completion summaries

### 🚀 Project Planning
- [TODO List](TODO.md) - Detailed task breakdown and progress
- [Installation Guide](docs/INSTALLATION.md) - Coming soon
- [Deployment Guide](docs/DEPLOYMENT.md) - Coming soon
- [Admin Manual](docs/ADMIN_GUIDE.md) - Coming soon
- [Development Setup](docs/DEVELOPMENT.md) - Coming soon

---

**Last Updated:** October 29, 2025

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework. You can also check out [Laravel Learn](https://laravel.com/learn), where you will be guided through building a modern Laravel application.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com)**
- **[Tighten Co.](https://tighten.co)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Redberry](https://redberry.international/laravel-development)**
- **[Active Logic](https://activelogic.com)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
