---
paths:
  - 'app/Providers/**'
---

# Providers

## Named validation rules live in ValidationServiceProvider
Add a new named validation rule as a `Validator::extend()` (or `extendImplicit()`) closure in `app/Providers/ValidationServiceProvider.php`, then reference it by its string name in `$rules`.

`app/Rules` is reserved for the encrypted-custom-field rule objects — do not add general-purpose rules there.

## Register observers in AppServiceProvider
Wire an observer with `Model::observe(ModelObserver::class)` in `AppServiceProvider::boot()`. Do not use the `#[ObservedBy]` attribute on the model.
