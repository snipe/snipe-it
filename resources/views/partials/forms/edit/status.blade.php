<!-- Status -->
<div class="form-group {{ $errors->has('status_id') ? ' has-error' : '' }}">
    <label for="status_id" class="col-md-3 control-label">{{ trans('admin/hardware/form.status') }}</label>
    <div class="col-md-7 col-sm-11{{  (\App\Helpers\Helper::checkIfRequired($item, 'status_id')) ? ' required' : '' }}">
        {{ Form::select('status_id', $statuslabel_list , Input::old('status_id', $item->status_id), array('class'=>'select2 status_id', 'style'=>'width:100%','id'=>'status_select_id')) }}
        {!! $errors->first('status_id', '<span class="alert-msg"><i class="fa fa-times"></i> :message</span>') !!}
    </div>
    <div class="col-md-2 col-sm-2 text-left">
        <a href='{{ route('modal.statuslabel') }}' data-toggle="modal"  data-target="#createModal" data-dependency='statuslabel' data-select='status_select_id' class="btn btn-sm btn-default">New</a>
        <span class="status_spinner" style="padding-left: 10px; color: green; display:none; width: 30px;"><i class="fa fa-spinner fa-spin"></i> </span>
    </div>

    <div class="col-md-7 col-sm-11 col-md-offset-3" id="status_helptext">
        <p id="selected_status_status" style="display:none;"></p>
    </div>

</div>
