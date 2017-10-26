<!-- Location -->
<div id="assigned_location" class="form-group{{ $errors->has($fieldname) ? ' has-error' : '' }}">
    {{ Form::label($fieldname, $translated_name, array('class' => 'col-md-3 control-label')) }}
    <div class="col-md-7 required">
        <select class="js-data-ajax" data-endpoint="locations" name="{{ $fieldname }}" style="width: 100%" id="assigned_location_select">
        </select>
    </div>

    <div class="col-md-1 col-sm-1 text-left">
        @can('create', \App\Models\Location::class)
            <a href='{{ route('modal.location') }}' data-toggle="modal"  data-target="#createModal" data-dependency="location" data-select='assigned_location_select' class="btn btn-sm btn-default">New</a>
        @endcan
    </div>

    {!! $errors->first($fieldname, '<div class="col-md-8 col-md-offset-3"><span class="alert-msg"><i class="fa fa-times"></i> :message</span></div>') !!}

</div>
