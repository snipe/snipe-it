<!-- Min QTY -->
<div class="form-group{{ $errors->has('min_amt') ? ' has-error' : '' }}">
    <label for="min_amt" class="col-md-3 control-label">{{ trans('general.min_amt') }}</label>
    <div class="col-md-9{{  (\App\Helpers\Helper::checkIfRequired($item, 'min_amt')) ? ' required' : '' }}">
       <div class="col-md-2" style="padding-left:0px">
            <input class="form-control col-md-3" type="text" name="min_amt" id="min_amt" value="{{ Input::old('min_amt', $item->min_amt) }}" />
        </div>
            <div class="col-md-7" style="margin-left: -15px;">
            <a href="#" data-toggle="tooltip" title="{{ trans('general.min_amt_help') }}"><i class="fa fa-info-circle"></i></a>
        </div>
        <div class="col-md-12">
           {!! $errors->first('min_amt', '<span class="alert-msg"><i class="fa fa-times"></i> :message</span>') !!}
        </div>
    </div>
</div>