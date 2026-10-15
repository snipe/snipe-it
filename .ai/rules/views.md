---
paths:
  - 'resources/views/**'
---

# Views

## Translations

UI strings are translation keys in `resources/lang/en-US/general.php` and its sibling files. Always add a new key rather
than hard-coding English in a view.

## Use trans(), never __()
Translate with `trans('general.some_key')` using short dotted keys from `resources/lang/<locale>/`. Never use `__()` — it appears nowhere in this codebase. Add a new key rather than hard-coding English.

## Blade composition: layouts plus anonymous components
Pages `@extends` a layout. Reusable markup is an anonymous Blade component: a file in `resources/views/components/` declaring `@props([...])`, used as `<x-name />`.

Do not create class-based components — there is no `app/View/Components` directory.
