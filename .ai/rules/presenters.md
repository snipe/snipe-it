---
paths:
  - 'app/Presenters/**'
---

# Presenters

## Presenters own display and datatable config
Display formatting and Bootstrap-table column config belong in `app/Presenters/<Entity>Presenter.php`, reached from the model via `$model->present()`.

Keep this logic out of controllers, transformers, and Blade.
