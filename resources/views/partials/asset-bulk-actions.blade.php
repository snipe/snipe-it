<div id="{{ (isset($id_divname)) ? $id_divname : 'assetsBulkEditToolbar' }}" style="min-width:400px">
{{ Form::open([
      'method' => 'POST',
      'route' => ['hardware/bulkedit'],
      'class' => 'form-inline',
      'id' => (isset($id_formname)) ? $id_formname : 'assetsBulkForm',
 ]) }}


    <label for="bulk_actions">
        <span class="sr-only">
            {{ trans('button.bulk_actions') }}
        </span>
    </label>
    <select name="bulk_actions" class="form-control select2" aria-label="bulk_actions" style="min-width: 350px;">
        @if((isset($status)) && ($status == 'Deleted'))
        @can('delete', \App\Models\Asset::class)
            <option value="restore">{{trans('button.restore')}}</option> 
        @endcan
        @else
        @can('update', \App\Models\Asset::class)
            <option value="edit">{{ trans('button.edit') }}</option>
        @endcan
        @can('delete', \App\Models\Asset::class)
            <option value="delete">{{ trans('button.delete') }}</option>
        @endcan
        <option value="labels" accesskey="l">{{ trans_choice('button.generate_labels', 2) }}</option>
        @endif
    </select>

    <button class="btn btn-primary" id="{{ (isset($id_button)) ? $id_button : 'bulkAssetEditButton' }}" disabled>{{ trans('button.go') }}</button>
    {{ Form::close() }}
</div>
<!-- Modal -->
<div id="myModal" class="modal fade">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">×</button>
                <h5 class="modal-title">example</h5>
            </div>

            <div class="modal-body">
                <h6 class="text-semibold text-center">example</h6>

                <div class="modal-footer">
                    <button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>
@if(Session::get('company_uniq') == 1)
    <script>
        $(function() {
            $('#myModal').modal('show');
        });
    </script>
@endif