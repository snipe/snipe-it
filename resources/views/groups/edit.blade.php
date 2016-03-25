@extends('layouts/default')

{{-- Web site Title --}}
@section('title')
{{ trans('admin/groups/titles.edit_group') }}
@parent
@stop

@section('header_right')
<a href="{{ route('groups') }}" class="btn btn-primary pull-right">
  {{ trans('general.back') }}</a>
@stop

{{-- Content --}}
@section('content')

    <style>
        label.radio-padding {
            margin-right: 25px;
        }
    </style>

  <div class="row">
    <div class="col-md-9">
      <div class="box box-default">

          @if ($group->id)
            <div class="box-header with-border">
              <div class="box-heading">
                <h3 class="box-title"> {{ $group->name }}</h3>
              </div>
            </div><!-- /.box-header -->
          @endif

        <div class="box-body">

          <form class="form-horizontal" method="post" action="" autocomplete="off">
          <!-- CSRF Token -->
          <input type="hidden" name="_token" value="{{ csrf_token() }}" />

          <!-- Name -->
          <div class="form-group {{ $errors->has('name') ? ' has-error' : '' }}">
              <label for="name" class="col-md-3 control-label">{{ trans('admin/groups/titles.group_name') }}
               <i class='fa fa-asterisk'></i></label>
               </label>
                  <div class="col-md-6">
                      <input class="form-control" type="text" name="name" id="name" value="{{ Input::old('name', $group->name) }}" />
                      {!! $errors->first('name', '<span class="alert-msg"><i class="fa fa-times"></i> :message</span>') !!}
                  </div>
          </div>
          <div class="col-md-9 col-md-offset-3">

          @foreach ($permissions as $area => $permission)

            @for ($i = 0; $i < count($area); $i++)
                <h3>{{ $area }}: {{ $permission[$i]['label'] }}</h3>
                <p>{{ $permission[$i]['note'] }}</p>

                <!-- radio -->
                <div class="form-group" style="padding-left: 15px;">
                <label class="radio-padding"><input type="radio" name="{{ $permission[$i]['permission']}}" class="minimal" value="1"> Grant</label>
                <label class="radio-padding"><input type="radio" name="{{ $permission[$i]['permission'] }}" class="minimal" value="0"> Deny</label>
            @endfor

            </div>

            <hr>
        @endforeach



        </div>

        <div class="box-footer text-right">
          <button type="submit" class="btn btn-success"><i class="fa fa-check icon-white"></i> {{ trans('general.save') }}</button>
        </div>
    </div>
  </div>



</form>

</div>
</div>
@stop
