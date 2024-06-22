<div id="{{ (isset($id_divname)) ? $id_divname : 'assetsBulkEditToolbar' }}" style="min-width:400px">
{{ Form::open([
      'method' => 'POST',
      'route' => ['hardware/bulkedit'],
      'class' => 'form-inline',
      'id' => (isset($id_formname)) ? $id_formname : 'assetsBulkForm',
 ]) }}

    {{-- The sort and order will only be used if the cookie is actually empty (like on first-use) --}}
    <input name="sort" type="hidden" value="assets.id">
    <input name="order" type="hidden" value="asc">
    <label for="bulk_actions">
        <span class="sr-only">
            {{ trans('button.bulk_actions') }}
        </span>
    </label>
    <select name="bulk_actions" class="form-control select2" aria-label="bulk_actions">
        @can('checkout', \App\Models\Asset::class)
            <option value="checkout">{{ trans('general.checkout') }}</option>
        @endcan
        @can(['checkin','checkout'], \App\Models\Asset::class)
            <option value="replace">Remplacer</option>
        @endcan
        @can('checkin', \App\Models\Asset::class)
            <option value="checkin">{{ trans('general.checkin') }}</option>
        @endcan
        @can('update', \App\Models\Asset::class)
            <option value="edit">{{ trans('button.edit') }}</option>
        @endcan
        @can('delete', \App\Models\Asset::class)
            <option value="delete">{{ trans('button.delete') }}</option>
        @endcan
        <option value="labels" accesskey="l">{{ trans_choice('button.generate_labels', 2) }}</option>
    </select>

    <button class="btn btn-primary" id="{{ (isset($id_button)) ? $id_button : 'bulkAssetEditButton' }}" disabled>{{ trans('button.go') }}</button>
    {{ Form::close() }}
</div>
