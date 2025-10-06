# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project Overview

This is a Laravel-based real estate platform for "Van der Meijden Vastgoed" - a property development management system. The application uses Laravel 12.0 with Filament 4.0 for the admin interface and Vite with Tailwind CSS for frontend assets.

## Key Technologies

- **Backend**: Laravel 12.0 (PHP 8.2+)
- **Admin Panel**: Filament 4.0
- **Frontend**: Vite 7.0, Tailwind CSS 4.0
- **Database**: Eloquent ORM with migrations
- **Testing**: PHPUnit 11.5.3

## Common Development Commands

### Development Server
```bash
# Start full development stack (server, queue, logs, vite)
composer run dev

# Start only Laravel server
php artisan serve

# Start only Vite frontend build
npm run dev
```

### Build and Production
```bash
# Build production assets
npm run build

# Build Vite assets
vite build
```

### Testing
```bash
# Run all tests
composer run test

# Run tests directly
php artisan test

# Run specific test
php artisan test --filter TestClassName
```

### Database
```bash
# Run migrations
php artisan migrate

# Fresh migration with seeding
php artisan migrate:fresh --seed

# Create new migration
php artisan make:migration create_table_name
```

### Code Quality
```bash
# Code formatting (Laravel Pint)
php artisan pint

# Clear configuration cache
php artisan config:clear
```

## Architecture Overview

### Core Domain Models
The system manages property development projects with these main entities:

- **Projects**: Central entity representing real estate development projects
- **Contractors**: Companies involved in demolition and construction
- **Tenders**: Bidding process for project work
- **WorkPreparations**: Planning and preparation activities
- **ProjectNotes & ProjectNoteReplies**: Communication and documentation

### Filament Admin Structure
The admin interface is organized into Filament Resources:
- `app/Filament/Resources/Projects/` - Project management
- `app/Filament/Resources/Contractors/` - Contractor management
- `app/Filament/Resources/Tenders/` - Tender management
- `app/Filament/Resources/WorkPreparations/` - Work preparation tracking
- `app/Filament/Resources/ProjectNotes/` - Project communication

### Key Relationships
- Projects have multiple Tenders, WorkPreparations, and ProjectNotes
- Projects belong to demolition and build Contractors
- ProjectNotes can have replies (ProjectNoteReplies)

## Project Structure Notes

- Uses standard Laravel directory structure
- Models in `app/Models/` with proper Eloquent relationships
- Database migrations in `database/migrations/`
- Filament resources follow the standard Filament patterns
- Frontend assets in `resources/` using Tailwind CSS
- Basic routing setup with only welcome route currently defined

## Development Workflow

1. Use `composer run dev` for full-stack development with hot reload
2. Database changes should be made via migrations
3. Follow Laravel and Filament conventions for new features
4. Test new functionality with PHPUnit
5. Use Laravel Pint for code formatting before commits