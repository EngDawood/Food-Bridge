# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## AI Guidance

* Ignore GEMINI.md and GEMINI-*.md files
* To save main context space, for code searches, inspections, troubleshooting or analysis, use code-searcher subagent where appropriate - giving the subagent full context background for the task(s) you assign it.
* After receiving tool results, carefully reflect on their quality and determine optimal next steps before proceeding. Use your thinking to plan and iterate based on this new information, and then take the best next action.
* For maximum efficiency, whenever you need to perform multiple independent operations, invoke all relevant tools simultaneously rather than sequentially.
* Before you finish, please verify your solution
* Do what has been asked; nothing more, nothing less.
* NEVER create files unless they're absolutely necessary for achieving your goal.
* ALWAYS prefer editing an existing file to creating a new one.
* NEVER proactively create documentation files (*.md) or README files. Only create documentation files if explicitly requested by the User.
* When you update or modify core context files, also update markdown documentation and memory bank
* When asked to commit changes, exclude CLAUDE.md and CLAUDE-*.md referenced memory bank system files from any commits. Never delete these files.

## Memory Bank System

This project uses a structured memory bank system with specialized context files. Always check these files for relevant information before starting work:

### Core Context Files

* **CLAUDE-activeContext.md** - Current session state, goals, and progress (if exists)
* **CLAUDE-patterns.md** - Established code patterns and conventions (if exists)
* **CLAUDE-decisions.md** - Architecture decisions and rationale (if exists)
* **CLAUDE-troubleshooting.md** - Common issues and proven solutions (if exists)
* **CLAUDE-config-variables.md** - Configuration variables reference (if exists)
* **CLAUDE-temp.md** - Temporary scratch pad (only read when referenced)

**Important:** Always reference the active context file first to understand what's currently being worked on and maintain session continuity.

### Memory Bank System Backups

When asked to backup Memory Bank System files, you will copy the core context files above and @.claude settings directory to directory @/path/to/backup-directory. If files already exist in the backup directory, you will overwrite them.

## Project Overview

**FoodBridge** is a Laravel-based web application designed to reduce food waste by connecting food donors, beneficiaries, and volunteers in Al-Jouf, Saudi Arabia. This is a student thesis project for Jouf University's Computer Science program, aligned with Saudi Vision 2030 sustainability goals.

### Technology Stack

**Backend:**
- Laravel 12 (PHP 8.2+)
- MySQL 8.2
- Composer for dependency management

**Frontend:**
- HTML5, Blade templating
- Tailwind CSS 4.0
- JavaScript (vanilla)
- Vite 6.0 build tool

**Development Tools:**
- Laravel Pint (code styling)
- Laravel Sail (Docker environment)
- PHPUnit (testing)
- Faker (test data generation)

### Architecture Patterns

- **MVC Architecture**: Standard Laravel structure with clear separation
- **Role-Based Access Control**: Four user roles (donor, beneficiary, volunteer, admin)
- **Service-Oriented Architecture**: Custom services for matching and notifications
- **Repository Pattern**: Used for data access abstraction
- **Factory Pattern**: Database factories for testing

### Core Features

1. **Multi-Role Authentication System**
   - Donors: Post surplus food donations
   - Beneficiaries: Request food and view matches
   - Volunteers: Manage delivery tasks
   - Admins: System oversight and reporting

2. **Food Donation Management**
   - CRUD operations for donations
   - Status tracking (pending, scheduled, delivered)
   - Expiration date and quantity tracking

3. **Request Matching System**
   - Automatic matching between donations and requests
   - Location-based coordination
   - Real-time notifications

4. **Delivery Coordination**
   - Volunteer task assignment
   - Delivery status tracking
   - Pickup and drop-off management

5. **Feedback & Rating System**
   - User feedback collection
   - Rating system for transactions
   - Quality assurance

## Common Development Commands

### Laravel Application Commands

```bash
# Development server
php artisan serve                    # Start local development server
composer run dev                     # Start with queue, logs, and Vite

# Database operations
php artisan migrate                  # Run migrations
php artisan migrate:fresh --seed    # Fresh migration with seeding
php artisan db:seed                 # Run seeders only

# Cache and optimization
php artisan config:clear            # Clear config cache
php artisan route:clear             # Clear route cache
php artisan view:clear              # Clear view cache
php artisan optimize:clear          # Clear all caches

# Code quality
./vendor/bin/pint                   # Run Laravel Pint (code styling)
php artisan test                    # Run PHPUnit tests

# Tinker (REPL)
php artisan tinker                  # Interactive PHP shell
```

### Frontend Asset Commands

```bash
# Vite development
npm run dev                         # Start Vite dev server
npm run build                       # Build for production

# Dependencies
npm install                         # Install Node.js dependencies
composer install                   # Install PHP dependencies
```

### Database Management

```bash
# Fresh start
php artisan migrate:fresh --seed    # Reset and seed database
php artisan make:migration          # Create new migration
php artisan make:factory            # Create model factory
php artisan make:seeder             # Create database seeder
```

## High-Level Architecture

### User Role Architecture

```
┌─────────────┐   ┌─────────────┐   ┌─────────────┐   ┌─────────────┐
│    Admin    │   │    Donor    │   │ Beneficiary │   │ Volunteer   │
└─────────────┘   └─────────────┘   └─────────────┘   └─────────────┘
       │                 │                 │                 │
       └─────────────────┼─────────────────┼─────────────────┘
                         │                 │
              ┌─────────────────────────────────┐
              │      Laravel Application        │
              │   ┌─────────────────────────┐   │
              │   │   Matching Service      │   │
              │   │   Notification Service │   │
              │   │   Role Middleware       │   │
              │   └─────────────────────────┘   │
              └─────────────────────────────────┘
                         │
              ┌─────────────────────────────────┐
              │        MySQL Database           │
              └─────────────────────────────────┘
```

### Database Schema Overview

**Core Tables:**
- `users` - Multi-role user management
- `donations` - Food donation records
- `requests` - Food request records (renamed from `food_requests`)
- `delivery_tasks` - Volunteer delivery coordination
- `feedback` - User rating and feedback system
- `notifications` - System notifications
- `reports` - Admin-generated reports

**Core Models:**
- `User` - Multi-role user model with role-based authentication
- `Donation` - Food donation model with status tracking
- `FoodRequest` - Food request model (table name: `requests`)
- `DeliveryTask` - Volunteer delivery task management
- `Feedback` - User feedback and ratings
- `SystemNotification` - In-app notification system
- `Report` - Admin report generation

### Key Patterns and Conventions

1. **Route Organization**: Grouped by user roles with middleware protection
   - `middleware(['auth', 'role:donor'])` - Donor-specific routes
   - `middleware(['auth', 'role:beneficiary'])` - Beneficiary routes
   - `middleware(['auth', 'role:volunteer'])` - Volunteer routes
   - `middleware(['auth', 'role:admin'])` - Admin routes
   - Uses `EnsureUserHasRole` middleware for role checking

2. **Controller Organization**:
   - Role-specific controllers: `DonationController`, `FoodRequestController`, `VolunteerController`
   - `AdminController` - Main admin operations
   - `Admin/` subdirectory - Specialized admin controllers (e.g., `DonationAdminController`)
   - `AuthController` - Authentication and profile management

3. **Service Layer Pattern**:
   - `MatchingService` - Handles donation-to-request matching logic
   - `NotificationService` - Manages user notifications
   - Service contracts in `app/Contracts/Services/` for dependency injection

4. **Naming Conventions**: Follow Laravel standards (snake_case for database, camelCase for PHP)

5. **Model Relationships**: Proper Eloquent relationships with foreign key constraints

6. **Blade Components**: Role-specific navigation partials
   - `nav-admin.blade.php` - Admin navigation
   - `nav-donor.blade.php` - Donor navigation
   - `nav-beneficiary.blade.php` - Beneficiary navigation
   - `nav-volunteer.blade.php` - Volunteer navigation

## Important Directory Structure

```
/home/dawood/FoodBridge/
├── app/
│   ├── Http/
│   │   ├── Controllers/                  # Request handling
│   │   │   ├── Admin/                    # Admin-specific controllers
│   │   │   ├── AdminController.php       # Main admin operations
│   │   │   ├── AuthController.php        # Authentication & profile
│   │   │   ├── DonationController.php    # Donor donation management
│   │   │   ├── FoodRequestController.php # Beneficiary requests
│   │   │   ├── VolunteerController.php   # Volunteer deliveries
│   │   │   ├── FeedbackController.php    # Feedback system
│   │   │   └── HomeController.php        # Landing page
│   │   └── Middleware/
│   │       └── EnsureUserHasRole.php     # Role-based access control
│   ├── Models/                           # Eloquent models
│   │   ├── User.php                      # Multi-role user model
│   │   ├── Donation.php                  # Food donation model
│   │   ├── FoodRequest.php               # Food request model
│   │   ├── DeliveryTask.php              # Delivery coordination
│   │   ├── Feedback.php                  # Feedback/ratings
│   │   ├── SystemNotification.php        # Notifications
│   │   └── Report.php                    # Admin reports
│   ├── Services/                         # Business logic layer
│   │   ├── MatchingService.php           # Donation-request matching
│   │   └── NotificationService.php       # User notifications
│   ├── Contracts/Services/               # Service interfaces
│   │   ├── MatchingServiceInterface.php
│   │   ├── NotificationServiceInterface.php
│   │   └── ReportServiceInterface.php
│   ├── Helpers/                          # Helper functions
│   └── Providers/
│       └── AppServiceProvider.php        # Service bindings
├── resources/
│   ├── views/                            # Blade templates
│   │   ├── layouts/
│   │   │   ├── app.blade.php             # Main layout
│   │   │   └── partials/                 # Navigation partials
│   │   │       ├── nav-admin.blade.php
│   │   │       ├── nav-donor.blade.php
│   │   │       ├── nav-beneficiary.blade.php
│   │   │       └── nav-volunteer.blade.php
│   │   ├── admin/                        # Admin interface
│   │   ├── donor/                        # Donor interface (donations)
│   │   ├── beneficiary/                  # Beneficiary interface (requests)
│   │   ├── volunteer/                    # Volunteer interface (deliveries)
│   │   └── auth/                         # Authentication views
│   ├── css/app.css                       # Tailwind CSS
│   └── js/
│       ├── app.js                        # Main JavaScript
│       └── bootstrap.js                  # Axios configuration
├── database/
│   ├── migrations/                       # Database schema versions
│   ├── factories/                        # Test data factories
│   └── seeders/                          # Database seeders
├── routes/
│   ├── web.php                           # Application routes
│   └── console.php                       # Artisan commands
└── tests/                                # PHPUnit tests
```

## Key Configuration Files

- `/home/dawood/FoodBridge/composer.json` - PHP dependencies and scripts
- `/home/dawood/FoodBridge/package.json` - Node.js dependencies and build scripts
- `/home/dawood/FoodBridge/vite.config.js` - Vite build configuration
- `/home/dawood/FoodBridge/config/database.php` - Database configuration
- `/home/dawood/FoodBridge/.env` - Environment variables (create from .env.example)

## Development Workflow

1. **Environment Setup**: Copy `.env.example` to `.env` and configure database
2. **Dependencies**: Run `composer install` and `npm install`
3. **Database**: Run `php artisan migrate:fresh --seed`
4. **Development**: Use `composer run dev` for full stack development
5. **Testing**: Run `php artisan test` for automated tests

## ALWAYS START WITH THESE COMMANDS FOR COMMON TASKS

**Task: "List/summarize all files and directories"**

```bash
rg --files                      # Lists ALL files recursively (FASTEST)
# OR
ls -R                           # Recursive listing (slower but always available)
```

**Task: "Search for content in files"**

```bash
rg "search_term"                # Search everywhere (FASTEST)
```

**Task: "Find files by name"**

```bash
rg --files | rg "filename"      # Find by name pattern
```

### Directory/File Exploration

```bash
# FIRST CHOICE - List all files/dirs recursively:
rg --files                      # All files (respects .gitignore)
ls -R                           # All files and directories (slower)

# For current directory only:
ls -la                          # Single directory view
```

### BANNED - Never Use These Slow Tools

* ❌ `tree` - NOT INSTALLED, use `rg --files` instead
* ❌ `fd` - NOT INSTALLED, use `rg --files` instead
* ❌ `find` - use `rg --files` instead
* ❌ `grep` or `grep -r` - use `rg` instead
* ❌ `cat file | grep` - use `rg pattern file`

### Use These Faster Tools Instead

```bash
# ripgrep (rg) - content search
rg "search_term"                # Search in all files
rg -i "case_insensitive"        # Case-insensitive
rg "pattern" -t php             # Only PHP files
rg "pattern" -g "*.blade.php"   # Only Blade templates
rg -l "pattern"                 # Filenames with matches
rg -c "pattern"                 # Count matches per file
rg -n "pattern"                 # Show line numbers
rg -A 3 -B 3 "error"            # Context lines (3 before, 3 after)
rg "(TODO|FIXME|HACK)"          # Multiple patterns

# ripgrep (rg) - file listing
rg --files                      # List all files (respects .gitignore)
rg --files | rg "pattern"       # Find files by name pattern
rg --files -g "*.php"           # Only PHP files
rg --files app/Models           # Files in specific directory

# jq - JSON processing
jq . data.json                  # Pretty-print
jq -r .name file.json           # Extract field
jq '.id = 0' x.json             # Modify field
```

### Search Strategy

1. Start broad, then narrow: `rg "partial" | rg "specific"`
2. Filter by type early: `rg -t php "function_name"`
3. Batch patterns: `rg "(pattern1|pattern2|pattern3)"`
4. Limit scope: `rg "pattern" app/`

### INSTANT DECISION TREE

```
User asks to "list/show/summarize/explore files"?
  → USE: rg --files  (respects .gitignore)
  → OR: ls -R  (shows everything including gitignored)

User asks to "search/grep/find text content"?
  → USE: rg "pattern"  (NOT grep!)

User asks to "find file/directory by name"?
  → USE: rg --files | rg "name"  (NOT find!)

User asks for "directory structure/tree"?
  → USE: rg --files | head -50  (first 50 files)
  → OR: ls -R  (full recursive listing)
  → NEVER: tree or fd (not installed!)

Need just current directory?
  → USE: ls -la  (OK for single dir)
```

## Git Workflow and Change Management

**IMPORTANT:** After every code update or feature implementation, follow this workflow:

1. **Stage Changes**: Add modified files to git staging area
   ```bash
   git add <modified-files>
   ```
2. **Commit with Descriptive Message**: Create a meaningful commit message (authored by you: EngDawood <davidhormos@gmail.com>)
   ```bash
   git commit -m "Brief summary

   Detailed description of changes...


   Co-Authored-By: EngDawood <davidhormos@gmail.com>"
   ```

   **Note:** Git is configured with your credentials. Commits are authored by you, with optional AI assistance attribution.

3. **Push to Remote**: Push commits to the remote repository
   ```bash
   git push
   ```

**Exception:** Do NOT commit CLAUDE.md, CLAUDE-*.md memory bank files, or .claude/ directory.
