---
paths:
  - 'tests/**'
---

# Tests

## Test environment uses array drivers

Feature tests hit the database. The test environment uses `array` drivers for cache, session, and mail.

## Database refresh comes from the base TestCase
`Tests\TestCase` already applies `LazilyRefreshDatabase` and seeds settings via `InitializesSettings`. Do not add `RefreshDatabase`, `DatabaseTransactions`, or `DatabaseMigrations` to an individual test.

## Test methods are snake_case
Name test methods in snake_case: `test_page_renders()`, `test_requires_permission()`. Never camelCase.

## UI GET routes need a render and a permission test

Every UI GET route should have both a `test_page_renders` test and a `test_requires_permission` test.

## Authenticate API tests with actingAsForApi()
Use `$this->actingAsForApi($user)` in API tests and `$this->actingAs($user)` in UI tests.

## Feature and unit test placement
Feature tests live in `tests/Feature/`, grouped by the feature or resource under test. A resource with both API and web controllers splits its tests into `Api/` and `Ui/` subfolders matching the layer under test; cross-cutting feature-area suites stay flat in their folder. Unit tests live in `tests/Unit/`, grouped by the type under test (`Models/`, `Presenters/`, `Transformers/`...).

## Avoid calling truncate() in tests — use delete() or forceDelete()

Avoid using `Model::truncate()` or `DB::table(...)->truncate()` in a test. Use `Model::query()->delete()` (soft delete)
or `Model::query()->forceDelete()` (hard delete) instead — both are DML and roll back normally.

Why: TRUNCATE is DDL, and MySQL implicitly commits on DDL. That destroys the transaction `LazilyRefreshDatabase` wraps
each test in. Laravel spots the dead transaction at teardown, clears `RefreshDatabaseState::$migrated`, and re-runs
all migrations before the next test — roughly 10s per occurrence on MySQL. SQLite hides the problem entirely
because its DDL is transactional, so this only shows up on a MySQL run.

The same trap applies to any runtime DDL, notably `Schema::table()` — which is why creating a `CustomField` (its
`created` hook does `ALTER TABLE assets`) is expensive on MySQL.

Tell: the test that runs the DDL looks fast; the *next* test pays. A test suddenly reporting ~1,690 queries is paying
for a re-migration.
