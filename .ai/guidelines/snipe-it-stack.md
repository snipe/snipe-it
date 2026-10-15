# Snipe-IT Stack & Tooling

## Frontend Is Laravel Mix, Not Vite

- Assets are built with **Laravel Mix (webpack)** via `webpack.mix.js`. This project has no `vite.config.js` and no Vite manifest.
- There is **no `npm run build` script**. Ignore any generic guidance that tells you to run it. Use:
    - `npm run dev` — development build
    - `npm run watch` — rebuild on change
    - `npm run prod` — production build
- If the user doesn't see a frontend change, ask them to run `npm run dev` or `npm run watch`.

## UI Layer

- **AdminLTE 2 / Bootstrap 3** Blade views. There is no Inertia.
- **Livewire v4 is installed** and used for discrete widgets in `app/Livewire` (e.g. `Importer`, `CustomFieldEditor`, `LdapSettings`). It is not the primary UI layer.
- Default to a Blade view plus a standard controller. Only reach for Livewire when extending an existing Livewire component or when the user asks for it.

## Charts

- **Chart.js v2.9.4**, bundled at `public/js/dist/Chart.min.js`.
- Use the **v2 API**, not v3. For example, the chart type is `horizontalBar` (v3 removed it in favor of `indexAxis`).
- Use `Helper::defaultChartColors()` for the 10-color palette.

## Commands

```bash
# Clear caches after config/route changes
php artisan optimize:clear

# Coverage reports (served by Laravel Herd)
herd coverage
```
