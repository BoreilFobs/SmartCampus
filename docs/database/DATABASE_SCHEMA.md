# SmartCampus Database Schema

## Overview
This document describes the complete database structure for the SmartCampus educational platform.

---

## Entity Relationship Diagram

```
┌─────────────────┐
│     USERS       │
├─────────────────┤
│ id              │
│ name            │
│ email           │
│ password        │
│ is_admin ◄──────┼─── Boolean flag for admin access
│ timestamps      │
└────────┬────────┘
         │
         │ created_by / uploaded_by (foreign keys)
         │
         ▼
┌─────────────────┐         ┌─────────────────┐         ┌─────────────────┐         ┌─────────────────┐
│     LEVELS      │         │    COURSES      │         │     VIDEOS      │         │     NOTES       │
├─────────────────┤         ├─────────────────┤         ├─────────────────┤         ├─────────────────┤
│ id (PK)         │────┐    │ id (PK)         │────┐    │ id (PK)         │────┐    │ id (PK)         │
│ name            │    │    │ level_id (FK) ──┼────┘    │ course_id (FK) ─┼────┘    │ video_id (FK) ──┼────┘
│ slug (unique)   │    └───►│ title           │    └───►│ title           │    └───►│ content (text)  │
│ description     │         │ slug (unique)   │         │ description     │         │ pdf_path        │
│ order           │         │ description     │         │ video_path ◄────┼─── VPS Storage Path
│ is_active       │         │ thumbnail_path  │         │ thumbnail_path  │         │ created_by (FK) │
│ timestamps      │         │ order           │         │ file_size       │         │ timestamps      │
└─────────────────┘         │ is_active       │         │ duration        │         └─────────────────┘
                            │ created_by (FK) │         │ order           │
HND1, HND2,                 │ timestamps      │         │ is_active       │         Study notes
Bachelor                    └─────────────────┘         │ uploaded_by(FK) │         and PDFs
                                                        │ timestamps      │
                            Courses per level           └─────────────────┘
                            
                                                        Videos stored on VPS
```

---

## Tables

### 1. **users** (Laravel default + modifications)
Stores administrator accounts for content management.

| Column       | Type         | Nullable | Default | Description                          |
|-------------|--------------|----------|---------|--------------------------------------|
| id          | bigint       | No       | -       | Primary key                          |
| name        | string       | No       | -       | Admin name                           |
| email       | string       | No       | -       | Unique email                         |
| password    | string       | No       | -       | Hashed password                      |
| **is_admin**| **boolean**  | **No**   | **false**| **Admin flag (new column)**         |
| timestamps  | timestamp    | No       | -       | created_at, updated_at               |

**Indexes:**
- PRIMARY KEY (`id`)
- UNIQUE (`email`)
- INDEX (`is_admin`)

---

### 2. **levels**
Academic levels (HND1, HND2, Bachelor).

| Column       | Type      | Nullable | Default | Description                          |
|-------------|-----------|----------|---------|--------------------------------------|
| id          | bigint    | No       | -       | Primary key                          |
| name        | string    | No       | -       | Level name (e.g., "HND 1")           |
| slug        | string    | No       | -       | URL-friendly slug (e.g., "hnd1")     |
| description | text      | Yes      | null    | Level description                    |
| order       | integer   | No       | 0       | Display order                        |
| is_active   | boolean   | No       | true    | Active/inactive status               |
| timestamps  | timestamp | No       | -       | created_at, updated_at               |

**Indexes:**
- PRIMARY KEY (`id`)
- UNIQUE (`slug`)
- INDEX (`is_active`)

**Sample Data:**
- HND 1 (slug: hnd1)
- HND 2 (slug: hnd2)
- Bachelor (slug: bachelor)

---

### 3. **courses**
Courses organized by academic level.

| Column          | Type      | Nullable | Default | Description                          |
|----------------|-----------|----------|---------|--------------------------------------|
| id             | bigint    | No       | -       | Primary key                          |
| level_id       | bigint    | No       | -       | Foreign key → levels.id              |
| title          | string    | No       | -       | Course title                         |
| slug           | string    | No       | -       | URL-friendly slug                    |
| description    | text      | Yes      | null    | Course description                   |
| thumbnail_path | string    | Yes      | null    | Path to course thumbnail             |
| order          | integer   | No       | 0       | Display order within level           |
| is_active      | boolean   | No       | true    | Active/inactive status               |
| created_by     | bigint    | Yes      | null    | Foreign key → users.id (admin)       |
| timestamps     | timestamp | No       | -       | created_at, updated_at               |

**Relationships:**
- `belongsTo` Level (level_id)
- `hasMany` Videos
- `belongsTo` User (created_by)

**Indexes:**
- PRIMARY KEY (`id`)
- UNIQUE (`slug`)
- INDEX (`level_id`)
- INDEX (`is_active`)
- COMPOSITE INDEX (`level_id`, `order`)

**Constraints:**
- ON DELETE CASCADE (when level is deleted)

---

### 4. **videos**
Video files stored on VPS server.

| Column          | Type           | Nullable | Default | Description                          |
|----------------|----------------|----------|---------|--------------------------------------|
| id             | bigint         | No       | -       | Primary key                          |
| course_id      | bigint         | No       | -       | Foreign key → courses.id             |
| title          | string         | No       | -       | Video title                          |
| description    | text           | Yes      | null    | Video description                    |
| **video_path** | **string**     | **No**   | **-**   | **Path to MP4 file on VPS**          |
| thumbnail_path | string         | Yes      | null    | Auto-generated thumbnail path        |
| file_size      | unsignedBigInt | Yes      | null    | File size in bytes                   |
| duration       | integer        | Yes      | null    | Duration in seconds (via FFmpeg)     |
| order          | integer        | No       | 0       | Playlist order within course         |
| is_active      | boolean        | No       | true    | Active/inactive status               |
| uploaded_by    | bigint         | Yes      | null    | Foreign key → users.id (admin)       |
| timestamps     | timestamp      | No       | -       | created_at, updated_at               |

**Relationships:**
- `belongsTo` Course (course_id)
- `hasOne` Note
- `belongsTo` User (uploaded_by)

**Indexes:**
- PRIMARY KEY (`id`)
- INDEX (`course_id`)
- INDEX (`is_active`)
- COMPOSITE INDEX (`course_id`, `order`)

**Constraints:**
- ON DELETE CASCADE (when course is deleted)

**Storage:**
- Videos stored in: `storage/app/public/videos/{course_id}/{video_id}.mp4`
- Thumbnails: `storage/app/public/thumbnails/videos/{video_id}.jpg`

---

### 5. **notes**
Study notes and downloadable PDFs for videos.

| Column      | Type      | Nullable | Default | Description                          |
|------------|-----------|----------|---------|--------------------------------------|
| id         | bigint    | No       | -       | Primary key                          |
| video_id   | bigint    | No       | -       | Foreign key → videos.id              |
| content    | text      | Yes      | null    | Rich text content (HTML)             |
| pdf_path   | string    | Yes      | null    | Path to downloadable PDF             |
| created_by | bigint    | Yes      | null    | Foreign key → users.id (admin)       |
| timestamps | timestamp | No       | -       | created_at, updated_at               |

**Relationships:**
- `belongsTo` Video (video_id)
- `belongsTo` User (created_by)

**Indexes:**
- PRIMARY KEY (`id`)
- INDEX (`video_id`)

**Constraints:**
- ON DELETE CASCADE (when video is deleted)

**Storage:**
- PDFs stored in: `storage/app/public/notes/{note_id}.pdf`

---

## Relationships Summary

### One-to-Many Relationships:
1. **Level → Courses** (1:N)
   - One level has many courses
   
2. **Course → Videos** (1:N)
   - One course has many videos
   
3. **Video → Notes** (1:1 or 1:N)
   - One video can have one or many notes
   
4. **User → Courses** (1:N) - created_by
   - One admin creates many courses
   
5. **User → Videos** (1:N) - uploaded_by
   - One admin uploads many videos
   
6. **User → Notes** (1:N) - created_by
   - One admin creates many notes

---

## Data Flow

```
Admin Login → Dashboard
     ↓
Create Level (HND1, HND2, Bachelor)
     ↓
Create Course (assign to level, upload thumbnail)
     ↓
Upload Video (MP4 file to VPS, FFmpeg extracts duration)
     ↓
Add Notes (rich text + PDF)
     ↓
Public Access (students view without login)
```

---

## Storage Structure on VPS

```
storage/
└── app/
    └── public/
        ├── videos/
        │   ├── 1/              # course_id = 1
        │   │   ├── 1.mp4       # video_id = 1
        │   │   ├── 2.mp4       # video_id = 2
        │   │   └── 3.mp4
        │   └── 2/              # course_id = 2
        │       └── 4.mp4
        ├── thumbnails/
        │   ├── courses/
        │   │   ├── 1.jpg
        │   │   └── 2.jpg
        │   └── videos/
        │       ├── 1.jpg       # Auto-generated from video
        │       └── 2.jpg
        └── notes/
            ├── 1.pdf
            └── 2.pdf
```

---

## Key Features

✅ **Admin-only content management** - All CRUD operations tracked  
✅ **VPS local storage** - No external video hosting  
✅ **Automatic metadata extraction** - Duration via FFmpeg  
✅ **Soft relationships** - Cascade deletes maintain integrity  
✅ **Optimized indexes** - Fast queries for public viewing  
✅ **File size tracking** - Monitor storage usage  
✅ **Ordering support** - Custom playlist ordering  

---

## Migration Order

1. `create_users_table` (Laravel default)
2. `create_levels_table`
3. `create_courses_table` (depends on levels)
4. `create_videos_table` (depends on courses)
5. `create_notes_table` (depends on videos)
6. `add_is_admin_to_users_table` (modifies users)

---

**Last Updated:** October 29, 2025
