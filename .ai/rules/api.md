---
paths:
  - 'app/Http/Controllers/Api/**'
---

# Api

## Wrap API responses in the standard envelope
Every API response goes through the shared envelope:

`return response()->json(Helper::formatStandardApiResponse('success', $payload, trans('...')));`

Use `'error'` with a `null` payload for failures, and a translation key for the message. There are no Eloquent API Resources in this project.

## Page API lists with offset and limit
API list endpoints (`index()`) page with `offset`/`limit` request params, resolved through the container as `app('api_offset_value')` and `app('api_limit_value')`, then applied with `->skip($offset)->take($limit)->get()`.

Do not use `paginate()`, `simplePaginate()`, or `cursorPaginate()` there.

## Select2 endpoints are the pagination exception
`selectlist()` methods must return a `LengthAwarePaginator`. `SelectlistTransformer::transformSelectlist()` type-hints one and derives select2's `pagination.more`, `total_count`, and `page_count` from `currentPage()`, `lastPage()`, `perPage()`, and `total()`, which drives select2's infinite scroll. A skip/take collection cannot be passed to it.

Use `->paginate(50)`:

```php
$users = $users->paginate(50);

return (new SelectlistTransformer)->transformSelectlist($users);
```

When the results have to be sorted or formatted as a collection first, `->get()` and wrap with `Helper::paginateCollection()`, which builds the paginator from `app('api_current_page')` and `app('api_limit_value')`:

```php
$companies = $companies->orderBy('name', 'ASC')->get();
// ...sorting/formatting...

return (new SelectlistTransformer)->transformSelectlist(Helper::paginateCollection($sorted));
```
