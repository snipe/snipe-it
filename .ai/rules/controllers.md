---
paths:
  - 'app/Http/Controllers/**'
---

# Controllers

## No DTOs or repository layer
Controllers build Eloquent queries inline and pass models, collections, and arrays around. There are no DTO or repository classes — do not introduce them. Extract to an Action or a Presenter when a controller method gets heavy.
