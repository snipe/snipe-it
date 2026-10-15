---
paths:
  - 'database/migrations/**'
---

# Migrations

## No foreign-key constraints
Relationship columns are plain `integer('other_id')` columns (nullable and indexed as needed). Do not add `foreignId()`, `foreignIdFor()`, `constrained()`, or `->foreign()->references()` — this schema has no FK constraints and referential integrity is enforced in application code.
