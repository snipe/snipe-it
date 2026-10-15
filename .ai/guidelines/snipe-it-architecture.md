# Snipe-IT Architecture

## Controllers

Two parallel controller trees:

- `app/Http/Controllers/` — web/UI controllers returning Blade views.
- `app/Http/Controllers/Api/` — REST API controllers returning JSON, consumed by datatables and select2.

Both trees use the same subdirectory groupings: `Assets/`, `Licenses/`, `Users/`, `Accessories/`, `Consumables/`, `Components/`, `Kits/`, `Account/`, `Auth/`.

## API Transformers

Every API controller returns data through a **Transformer** in `app/Http/Transformers/`. Never return raw model attributes from an API controller. `DatatablesTransformer` wraps paginated results.

```php
return (new AssetsTransformer)->transformAssets($assets, $assets->count());
```

## Authorization

- All authorization goes through **Policies** in `app/Policies/`.
- `CheckoutablePermissionsPolicy` is the base for assets, licenses, accessories, and consumables.
- Its `checkout()` / `checkin()` methods accept `$item = null`, so `@can('checkout', \App\Models\Asset::class)` works without an instance.

## Routes

- UI routes live in `routes/web.php` **and** in the per-entity files under `routes/web/` (`hardware.php`, `users.php`, `licenses.php`, `accessories.php`, `components.php`, `consumables.php`, `kits.php`, `models.php`, `fields.php`, `locations.php`). Check both when adding or locating a UI route.
- API routes are in `routes/api.php`.
- Breadcrumbs are defined inline with `->breadcrumbs(fn (Trail $trail) => ...)` from `tabuna/breadcrumbs`. **Every UI route should have a breadcrumb.**
- Some route names contain slashes rather than dots. For example, use `route('reports/unaccepted_assets')`.

## Full Multiple Company Support (FMCS)

`Setting::getSettings()->full_multiple_companies_support == '1'` gates company-scoped filtering. The select2 endpoints (`selectlist()` methods) accept a `companyId` query param:

```php
if ((Setting::getSettings()->full_multiple_companies_support == '1') && ($request->filled('companyId'))) {
    $query->where('table.company_id', $request->input('companyId'));
}
```

Wire it up from Blade with `data-company-id="{{ $user->company_id }}"`.

## Select2 AJAX Dropdowns

Use `class="js-data-ajax"` with `data-endpoint="hardware|licenses|consumables|..."`. `snipeit.js` auto-initializes these, forwarding `data-company-id` as `companyId` and `data-asset-status-type` as `statusType` to the API.

## Checkout Redirect Flow

After checkout, `Helper::getRedirectOption()` reads `$request->redirect_option`. To redirect back to the assigned user, the form must set:

- `redirect_option=target`
- `checkout_to_type=user`
- `assigned_user={{ $user->id }}`

## Global View Variables

`$snipeSettings` is shared with every view by `SettingsServiceProvider`. Use it directly in Blade — do not pass `Setting::getSettings()` from the controller.

## Key Helper Methods (`app/Helpers/Helper.php`)

- `Helper::deployableStatusLabelList()` — status labels for checkout forms.
- `Helper::defaultChartColors(int $index = 0)` — 10-color chart palette.
- `Helper::getRedirectOption($request, $id, $table, $item_id = null)` — post-checkout redirect logic.
