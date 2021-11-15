<!-- Classification Level -->
<div class="form-group {{ $errors->has('classification_level') ? ' has-error' : '' }}">
    <label for="classification_level" class="col-md-3 control-label">{{ trans('admin/hardware/form.status') }}</label>
    <div class="col-md-7 col-sm-11{{  (\App\Helpers\Helper::checkIfRequired($item, 'classification_level')) ? ' required' : '' }}">
        {{ Form::select('classification_level', $statuslabel_list , old('classification_level', $item->classification_level), array('class'=>'select2 classification_level', 'style'=>'width:100%','id'=>'status_select_id', 'aria-label'=>'classification_level', 'data-validation' => "required")) }}
        {!! $errors->first('classification_level', '<span class="alert-msg" aria-hidden="true"><i class="fa fa-times" aria-hidden="true"></i> :message</span>') !!}
    </div>
    <div class="col-md-2 col-sm-2 text-left">

        @can('create', \App\Models\Statuslabel::class)
            <a href='{{ route('modal.show', 'statuslabel') }}' data-toggle="modal"  data-target="#createModal" data-select='status_select_id' class="btn btn-sm btn-primary">New</a>
        @endcan

        <span class="status_spinner" style="padding-left: 10px; color: green; display:none; width: 30px;"><i class="fa fa-spinner fa-spin" aria-hidden="true"></i> </span>

    </div>

    <div class="col-md-7 col-sm-11 col-md-offset-3" id="status_helptext">
        <p id="selected_status_status" style="display:none;"></p>
    </div>

</div>
