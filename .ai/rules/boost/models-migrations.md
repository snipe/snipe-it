---
paths:
  - 'app/Models/**'
  - 'database/migrations/**'
---

# Models Migrations

- Laravel 12 allows limiting eagerly loaded records natively, without external packages: `$query->latest()->limit(10);`.

### Models

- Casts can and likely should be set in a `casts()` method on a model rather than the `$casts` property. Follow existing conventions from other models.
