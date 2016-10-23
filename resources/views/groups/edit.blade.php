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
    <div class="col-md-8 col-md-offset-2">
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
                  <div class="col-md-6 required">
                      <input class="form-control" type="text" name="name" id="name" value="{{ Input::old('name', $group->name) }}" />
                      {!! $errors->first('name', '<span class="alert-msg"><i class="fa fa-times"></i> :message</span>') !!}
                  </div>
          </div>

          <div class="col-md-8 col-md-offset-3">

          @foreach ($permissions as $area => $permission)

            @for ($i = 0; $i < count($permission); $i++)
                <?php
                $permission_name = $permission[$i]['permission'];
                ?>

                @if ($permission[$i]['display'])
                    <h3>{{ $area }}: {{ $permission[$i]['label'] }}</h3>
                    <p>{{ $permission[$i]['note'] }}</p>

                    <!-- radio -->
                    <div class="form-group" style="padding-left: 15px;">

                        <label class="radio-padding">
                        {{ Form::radio('permission['.$permission_name.']', 1,
                        (array_key_exists($permission_name, $groupPermissions) && $groupPermissions[$permission_name]), ['class' => 'minimal']) }}
                        Grant</label>

                        <label class="radio-padding">
                         {{ Form::radio('permission['.$permission_name.']', 0, (!array_key_exists($permission_name, $groupPermissions) || !$groupPermissions[$permission_name]), ['class' => 'minimal']) }}
                        Deny</label>
                    </div>
                    <hr>
              @endif
            @endfor
        @endforeach

        </div>

        <hr>

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
