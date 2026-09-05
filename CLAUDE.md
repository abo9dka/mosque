# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project overview

A Laravel 12 app for managing a mosque's Quran-memorization program: teachers (`users`) log in and track their `students`' attendance, memorization/review progress, and a points system. All UI text, routes' comments, and validation messages are in Arabic; views render RTL (`dir="rtl"`, `lang="ar"`).

## Commands

Run PHP/Composer/Artisan commands with `php`/`composer` directly (no Sail/Docker in use).

- Install deps: `composer install` && `npm install`
- Full first-time setup (copies `.env`, generates key, migrates, builds assets): `composer run setup`
- Local dev (serves app + queue listener + `pail` logs + Vite, concurrently): `composer run dev`
- Serve only: `php artisan serve`
- Build/watch frontend assets: `npm run build` / `npm run dev`
- Run all tests: `composer run test` (clears config cache, then `php artisan test`)
- Run a single test file: `php artisan test tests/Feature/ExampleTest.php`
- Run a single test by name: `php artisan test --filter=testName`
- Lint/format PHP (Laravel Pint): `vendor/bin/pint`
- Run migrations: `php artisan migrate`
- Tinker REPL: `php artisan tinker`

Tests run against in-memory SQLite (`phpunit.xml` sets `DB_CONNECTION=sqlite`, `DB_DATABASE=:memory:`), independent of the dev DB configured in `.env`.

## Architecture

- **Auth**: Teachers log in with `phone` + `password` (not email) — see `AuthController` and the `users` migration/model. There is no registration route; users must be seeded/created manually (e.g. via `DatabaseSeeder` or `tinker`).
- **Domain model**: `User` (teacher) → has many `Student` → each `Student` has many `ProgressLog` and `AttendanceLog`.
  - `Student.points` is the running score, mutated directly by `StudentController::addPoints`/`subtractPoints` and indirectly by attendance penalties.
  - `AttendanceLog` status is one of the Arabic string constants on the model (`STATUS_PRESENT`, `STATUS_EXCUSED_ABSENCE`, `STATUS_UNEXCUSED_ABSENCE`, `STATUS_LATE`); `AttendanceLog::penaltyFor()` maps status to a points penalty (unexcused absence = -10, late = -5). When attendance is re-saved for the same student/date, `DashboardController::storeAttendance` diffs the old vs. new penalty before adjusting points, so re-submitting the same day's attendance doesn't double-penalize.
  - `ProgressLog` is a single table for two distinct log types distinguished by `type`: `memorization` (new memorization: surah/ayah range, homework, daily review) and `big_review` (weekly cumulative review). Fields relevant to one type are simply left null for the other — there's no STI/polymorphism, just one flat schema.
- **Routing** (`routes/web.php`): two middleware groups — `guest` (login page) and `auth` (everything else: dashboard, attendance, student CRUD, follow/progress, points). All authenticated routes are teacher-scoped implicitly via `auth()->id()`, but note this scoping is applied inconsistently — e.g. `StudentController::edit`/`update`/`follow`/`storeFollow` fetch by `findOrFail($id)` alone without checking `user_id` ownership, while `store`/`delete` do scope to the current user. Keep this in mind (and prefer scoping to the current teacher) when touching student-facing endpoints.
- **Views**: server-rendered Blade in `resources/views/` (no SPA/API layer). Styling is a mix of Tailwind (via `resources/css/app.css` + Vite) and hand-written per-page CSS served directly from `public/css/*.css` (e.g. `dashboard.blade.php` links `asset('css/dashboard.css')` directly, bypassing the Vite pipeline) — check `public/css/` as well as `resources/css/` when changing page styles.
- **Database**: SQLite by default (`database/database.sqlite`), configurable via `.env`. Migrations include a couple of follow-up/refactor migrations (e.g. widening/narrowing the `attendance_logs.status` enum, changing `students.points` from string to integer) rather than editing the original migration — follow that pattern for schema changes instead of rewriting historical migrations.
