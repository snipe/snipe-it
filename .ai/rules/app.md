---
paths:
  - 'app/**'
---

# App

## Translations

UI strings are translation keys in `resources/lang/en-US/general.php` and its sibling files. Always add a new key rather
than hard-coding English in a view.

## Use trans(), never __()
Translate with `trans('admin/hardware/message.some_key')` using short dotted keys from `resources/lang/<locale>/`. Never use `__()` — it appears nowhere in this codebase. Add a new key rather than hard-coding English.
