@if (\App\Models\Company::isCurrentUserAuthorized())
<div class="form-group {{ $errors->has('company_id') ? ' has-error' : '' }}">
   <div class="col-md-3 control-label">{{ Form::label('company_id', trans('general.company')) }}</div>
    <div class="col-md-7 col-sm-12{{  (\App\Helpers\Helper::checkIfRequired($item, 'company_id')) ? ' required' : '' }}">
       {{ Form::select('company_id', $company_list , Input::old('company_id', $item->company_id), array('class'=>'select2', 'style'=>'width:100%')) }}
       {!! $errors->first('company_id', '<span class="alert-msg"><i class="fa fa-times"></i> :message</span>') !!}
   </div>
</div>
@endif