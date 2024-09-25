@if (\App\Models\Company::isCurrentUserAuthorized())
<div class="form-group {{ $errors->has('company_id') ? ' has-error' : '' }}">
   <div class="col-md-3 control-label">
       <x-form-error name="company_id" />
   </div>
    <div class="col-md-7 col-sm-12{{  (Helper::checkIfRequired($item, 'company_id')) ? ' required' : '' }}">
       {{ Form::select('company_id', $company_list , old('company_id', $item->company_id), array('class'=>'select2', 'style'=>'width:100%')) }}
        <x-form-error name="company_id" />
   </div>
</div>
@endif
