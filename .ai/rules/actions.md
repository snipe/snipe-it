---
paths:
  - 'app/Actions/**'
---

# Actions

## Actions expose a single static run() method
An Action is a class in `app/Actions/<Entity>/` named `<Verb><Entity>Action`, with one `public static function run(...)` and no constructor. Call it statically: `DestroySupplierAction::run(supplier: $supplier)`.

Do not use `handle()`, `execute()`, `__invoke()`, or instantiate the class.
