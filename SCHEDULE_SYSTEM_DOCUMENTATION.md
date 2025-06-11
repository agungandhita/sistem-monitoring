# Class Schedule System - Backend Documentation

## Overview

This document describes the complete backend implementation for a class schedule (timetable) system that automatically assigns students to their respective class groups (rombel) based on created schedules.

## Database Schema

### New Tables Created

#### 1. `rombels` Table
Stores class groups (rombongan belajar)
- `rombel_id` (Primary Key)
- `nama_rombel` (e.g., "7A", "8B")
- `tingkat` (Grade level: "7", "8", "9")
- `kelas` (Class section: "A", "B", "C")
- `kurikulum_id` (Foreign Key to kurikulums)
- `tahun_ajaran` (Academic year)
- `kapasitas` (Maximum capacity)
- `jumlah_siswa` (Current student count)
- `status` (aktif/tidak_aktif)
- `keterangan` (Notes)

#### 2. `time_slots` Table
Defines time periods in a school day
- `time_slot_id` (Primary Key)
- `nama_slot` (e.g., "Jam ke-1", "Istirahat")
- `jam_mulai` (Start time)
- `jam_selesai` (End time)
- `urutan` (Sequence order)
- `jenis` (pelajaran/istirahat/sholat)
- `hari` (Day of week)
- `aktif` (Active status)

#### 3. `schedules` Table
Main schedule entries connecting all components
- `schedule_id` (Primary Key)
- `rombel_id` (Foreign Key to rombels)
- `time_slot_id` (Foreign Key to time_slots)
- `mapel_id` (Foreign Key to mapels)
- `guru_id` (Foreign Key to gurus)
- `kurikulum_id` (Foreign Key to kurikulums)
- `hari` (Day of week)
- `ruang_kelas` (Classroom)
- `jenis_kegiatan` (Activity type)
- `nama_kegiatan` (Activity name)
- `catatan` (Notes)
- `aktif` (Active status)

#### 4. `rombel_siswa` Table
Pivot table for student-rombel assignments
- `rombel_id` (Foreign Key to rombels)
- `siswa_id` (Foreign Key to siswas)
- `tahun_ajaran` (Academic year)
- `tanggal_masuk` (Assignment date)
- `tanggal_keluar` (Removal date)
- `status` (aktif/pindah/keluar)
- `keterangan` (Notes)

## Models and Relationships

### 1. Rombel Model
**Location**: `app/Models/Rombel.php`

**Key Methods**:
- `siswas()` - Many-to-many relationship with students
- `activeSiswas()` - Get only active students
- `schedules()` - One-to-many relationship with schedules
- `schedulesForDay($day)` - Get schedules for specific day
- `weeklySchedule()` - Get complete weekly schedule
- `updateStudentCount()` - Update student count automatically
- `hasAvailableCapacity()` - Check if rombel has space

**Scopes**:
- `active()` - Filter active rombels
- `forAcademicYear($year)` - Filter by academic year
- `forGrade($grade)` - Filter by grade level

### 2. TimeSlot Model
**Location**: `app/Models/TimeSlot.php`

**Key Methods**:
- `schedules()` - One-to-many relationship with schedules
- `getDurationInMinutes()` - Calculate duration
- `getTimeRange()` - Get formatted time range
- `conflictsWith(TimeSlot $other)` - Check time conflicts

**Scopes**:
- `active()` - Filter active time slots
- `forDay($day)` - Filter by day
- `lessonPeriods()` - Filter lesson periods only
- `breakPeriods()` - Filter break periods only
- `ordered()` - Order by sequence

### 3. Schedule Model
**Location**: `app/Models/Schedule.php`

**Key Methods**:
- `getDisplayName()` - Get subject or activity name
- `getTeacherName()` - Get teacher name
- `hasTeacherConflict()` - Check teacher conflicts
- `hasRoomConflict()` - Check room conflicts

**Static Methods**:
- `getWeeklyScheduleForRombel($rombelId)` - Get weekly schedule
- `getDailyScheduleForTeacher($guruId, $day)` - Get teacher's daily schedule
- `getConflicts($scheduleData)` - Validate for conflicts

**Scopes**:
- `active()` - Filter active schedules
- `forDay($day)` - Filter by day
- `forRombel($rombelId)` - Filter by rombel
- `forTeacher($guruId)` - Filter by teacher
- `lessons()` - Filter lesson activities only

### 4. Updated Siswa Model
**Location**: `app/Models/Siswa.php`

**New Methods Added**:
- `rombels()` - Many-to-many relationship with rombels
- `currentRombel($tahunAjaran)` - Get current active rombel
- `getSchedule($tahunAjaran)` - Get student's schedule
- `hasRombelForYear($tahunAjaran)` - Check rombel assignment

**New Scopes**:
- `withoutRombel($tahunAjaran)` - Students without rombel
- `inGrade($tingkat)` - Students in specific grade

## Service Layer

### ScheduleService
**Location**: `app/Services/ScheduleService.php`

This service handles complex business logic for schedule management.

**Key Methods**:

#### `createScheduleForRombel($rombelId, $scheduleData)`
Creates a complete schedule for a rombel with validation and conflict checking.

**Parameters**:
- `$rombelId` - ID of the rombel
- `$scheduleData` - Array of schedule entries

**Returns**:
```php
[
    'success' => true/false,
    'schedules' => [...], // Created schedules
    'conflicts' => [...], // Any conflicts found
    'message' => 'Status message'
]
```

#### `autoAssignStudentsToRombel($kurikulumId, $tahunAjaran)`
Automatically assigns students to rombels based on grade level and capacity.

**Logic**:
1. Get all active rombels for curriculum and academic year
2. For each rombel, find students of matching grade level
3. Assign students up to rombel capacity
4. Update student counts
5. Track unassigned students

**Returns**:
```php
[
    'success' => true/false,
    'assignments' => [...], // Student-rombel assignments
    'unassigned_students' => [...], // Students not assigned
    'message' => 'Status message'
]
```

#### `generateTimetableGrid($rombelId)`
Generates a visual timetable grid for display.

**Returns**:
```php
[
    'rombel' => Rombel,
    'grid' => [
        'senin' => [
            'time_slot_id' => [
                'time_slot' => TimeSlot,
                'schedule' => Schedule,
                'subject' => 'Subject name',
                'teacher' => 'Teacher name',
                'room' => 'Room name',
                'type' => 'Activity type'
            ]
        ]
    ],
    'days' => ['senin', 'selasa', ...],
    'time_slots' => TimeSlot collection
]
```

## Controller Layer

### ScheduleController
**Location**: `app/Http/Controllers/ScheduleController.php`

**Key Actions**:

#### `index()`
Displays schedule management dashboard with all rombels and curricula.

#### `create(Request $request)`
Shows form to create schedule for a rombel.
**Query Parameters**:
- `rombel_id` - Pre-select specific rombel

#### `store(Request $request)`
Stores new schedule and auto-assigns students.

**Validation Rules**:
```php
'rombel_id' => 'required|exists:rombels,rombel_id',
'schedules' => 'required|array',
'schedules.*.time_slot_id' => 'required|exists:time_slots,time_slot_id',
'schedules.*.hari' => 'required|in:senin,selasa,rabu,kamis,jumat,sabtu,minggu',
'schedules.*.jenis_kegiatan' => 'required|in:pelajaran,istirahat,sholat,upacara,ekstrakurikuler',
// ... more validation rules
```

#### `show($rombelId)`
Displays timetable grid for specific rombel.

#### `teacherSchedule($guruId)`
Displays teacher's weekly schedule.

#### `autoAssignStudents(Request $request)`
Manually trigger student auto-assignment.

**API Endpoints**:
- `getScheduleData()` - Get schedule data as JSON
- `checkConflicts()` - Validate schedule conflicts

## Database Seeders

### TimeSlotSeeder
**Location**: `database/seeders/TimeSlotSeeder.php`

Creates default time slots for all days:
- Regular days: 10 periods (8 lessons + 2 breaks)
- Friday: 10 periods (7 lessons + 2 breaks + Jum'at prayer)

**Time Structure**:
- Lesson duration: 40 minutes (35 minutes on Friday)
- Break 1: 15 minutes
- Break 2: 15 minutes
- Jum'at prayer: 1 hour 25 minutes

### RombelSeeder
**Location**: `database/seeders/RombelSeeder.php`

Creates sample rombels:
- Grade 7: Classes A, B, C
- Grade 8: Classes A, B, C
- Grade 9: Classes A, B
- Capacity: 30 students each

## Routes

### Schedule Routes
**Prefix**: `/schedule`
**Middleware**: `admin`

```php
// Main CRUD operations
GET    /schedule              -> index
GET    /schedule/create       -> create
POST   /schedule              -> store
GET    /schedule/{rombel}/show -> show
GET    /schedule/{rombel}/edit -> edit
PUT    /schedule/{rombel}     -> update
DELETE /schedule/entry/{schedule} -> destroy

// Additional features
GET    /schedule/teacher/{guru} -> teacherSchedule
GET    /schedule/api/data      -> getScheduleData
POST   /schedule/api/conflicts -> checkConflicts
POST   /schedule/auto-assign   -> autoAssignStudents
```

## Usage Workflow

### 1. Initial Setup
1. Run migrations to create tables
2. Run seeders to populate time slots and sample rombels
3. Ensure subjects (mapels) and teachers (gurus) are created

### 2. Creating Schedules
1. Navigate to `/schedule/create`
2. Select a rombel
3. Fill in the timetable grid:
   - Select subject and teacher for each time slot
   - Specify classroom if needed
   - Add notes if necessary
4. Submit the form
5. System validates for conflicts
6. If valid, schedule is created and students are auto-assigned

### 3. Student Auto-Assignment Logic
When a schedule is created:
1. System identifies the rombel's grade level
2. Finds all students in that grade without rombel assignment
3. Assigns students to rombel up to capacity limit
4. Updates rombel student count
5. Reports assignment results

### 4. Viewing Schedules
- **Rombel Schedule**: `/schedule/{rombel}/show` - Visual timetable grid
- **Teacher Schedule**: `/schedule/teacher/{guru}` - Teacher's weekly schedule
- **Dashboard**: `/schedule` - Overview of all schedules

### 5. Conflict Detection
System automatically detects:
- **Teacher Conflicts**: Same teacher assigned to multiple classes at same time
- **Room Conflicts**: Same room assigned to multiple classes at same time
- **Rombel Conflicts**: Multiple activities for same rombel at same time

## Key Features

### 1. Automatic Student Assignment
- Students are automatically placed in appropriate rombels based on grade level
- Respects rombel capacity limits
- Tracks unassigned students when capacity is exceeded

### 2. Conflict Prevention
- Real-time validation prevents scheduling conflicts
- Checks teacher availability
- Validates room availability
- Ensures no double-booking

### 3. Flexible Schedule Types
- Regular lessons with subject and teacher
- Break periods
- Prayer times
- Special activities (upacara, ekstrakurikuler)

### 4. Visual Timetable Grid
- Clean, readable timetable display
- Color-coded activity types
- Teacher and room information
- Easy navigation between days

### 5. Teacher Schedule Management
- View individual teacher schedules
- Track teaching load
- Identify free periods

## Database Relationships Summary

```
Kurikulum (1) -----> (N) Rombel (1) -----> (N) Schedule (N) <----- (1) TimeSlot
    |                     |                      |                        |
    |                     |                      |                        |
    v                     v                      v                        v
GuruMapel            RombelSiswa              Mapel                   (Days)
    |                     |                      |
    v                     v                      v
  Guru                 Siswa                 (Subjects)
```

## Next Steps

This backend implementation provides:
1. ✅ Complete database schema
2. ✅ Model relationships and business logic
3. ✅ Service layer for complex operations
4. ✅ Controller with full CRUD operations
5. ✅ Automatic student assignment
6. ✅ Conflict detection and validation
7. ✅ Seeders for initial data
8. ✅ Routing configuration

**Ready for Frontend Development**: The backend is now complete and ready for frontend implementation with views, forms, and user interface components.