@can('delete', \App\Models\Location::class)
    <div id="locationsBulkEditToolbar">
    {{ Form::open([
              'method' => 'POST',
              'route' => ['locations.bulkdelete.show'],
              'class' => 'form-inline',
              'id' => 'locationsBulkForm']) }}

            <div id="locations-toolbar">
                <label for="bulk_actions" class="sr-only">{{ trans('general.bulk_actions') }}</label>
                <select name="bulk_actions" class="form-control select2" style="width: 200px;" aria-label="bulk_actions">
                    <option value="delete">{{ trans('general.bulk_delete') }}</option>
                </select>
                <button class="btn btn-primary" id="bulkLocationsEditButton" disabled>{{ trans('button.go') }}</button>
            </div>

    {{ Form::close() }}
    </div>
@endcan

