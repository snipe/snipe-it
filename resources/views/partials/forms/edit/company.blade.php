@if (\App\Models\Company::isCurrentUserAuthorized())
<div class="form-group {{ $errors->has('company_id') ? ' has-error' : '' }}">
   <div class="col-md-3 control-label">
       <label for="company_id" class="col-md-3 control-label">{{ trans('general.company') }}</label>
   </div>
    <div class="col-md-7 col-sm-12">
       {{ Form::select('company_id', $company_list , old('company_id', $item->company_id), array('class'=>'select2', 'style'=>'width:100%', 'required' => Helper::checkIfRequired($item, 'company_id') ? true : '')) }}
       {!! $errors->first('company_id', '<span class="alert-msg" aria-hidden="true"><i class="fas fa-times" aria-hidden="true"></i> :message</span>') !!}
   </div>
</div>
@endif
