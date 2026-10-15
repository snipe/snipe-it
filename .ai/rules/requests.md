---
paths:
  - 'app/Http/Requests/**'
---

# Requests

## Form Requests are the validation entry point
Validate HTTP input with a Form Request class, not inline `$request->validate()` or `Validator::make()`.

Extend `App\Http\Requests\Request` and declare rules in the `protected $rules` property — the base class returns it from `rules()`. When the request handles file uploads, extend `ImageUploadRequest` instead and call `$request->handleImages($model)` in the controller.

## Always call parent::prepareForValidation()
`ImageUploadRequest` inherits `prepareForValidation()` from the `ConvertsBase64ToFiles` trait, which turns base64 payloads into `UploadedFile` instances before rules run.

If a child request overrides `prepareForValidation()`, it MUST call `parent::prepareForValidation()` — usually first. Forgetting it silently breaks base64 image uploads with no validation error to point at. This has bitten us before.
