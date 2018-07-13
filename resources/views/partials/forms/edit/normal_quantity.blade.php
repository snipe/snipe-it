<!-- Normal QTY -->
<div class="form-group{{ $errors->has('normal_amt') ? ' has-error' : '' }}">
    <label for="normal_amt" class="col-md-3 control-label">{{ trans('general.normal_amt') }}</label>
    <div class="col-md-9{{  (\App\Helpers\Helper::checkIfRequired($item, 'normal_amt')) ? ' required' : '' }}">
       <div class="col-md-2" style="padding-left:0px">
            <input class="form-control col-md-3" type="text" name="normal_amt" id="normal_amt" value="{{ Input::old('normal_amt', $item->normal_amt) }}" />
        </div>
            <div class="col-md-7" style="margin-left: -15px;">
            <a href="#" data-toggle="tooltip" title="{{ trans('general.normal_amt_help') }}"><i class="fa fa-info-circle"></i></a>
        </div>
        <div class="col-md-12">
           {!! $errors->first('normal_amt', '<span class="alert-msg"><i class="fa fa-times"></i> :message</span>') !!}
        </div>
    </div>
</div>