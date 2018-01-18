@extends('layouts/default')

{{-- Page title --}}
@section('title')
Bulk Checkin &amp; Delete
@parent
@stop

{{-- Page content --}}
@section('content')

<div class="row">
  <div class="col-md-8 col-md-offset-2">
    <div class="box box-default">
      <form class="form-horizontal" role="form" method="post" action="{{ route('users/bulksave') }}">
        <div class="box-body">
          <!-- CSRF Token -->
          {{csrf_field()}}
          <div class="col-md-12">
            <div class="callout callout-danger">
              <i class="fa fa-exclamation-circle"></i>
              <strong>警告: </strong>
              你将删除{{ count($users) }} 用户. 超级管理员名称用红色高亮显示。
            </div>
          </div>

          @if (config('app.lock_passwords'))
            <div class="col-md-12">
              <div class="callout callout-warning">
                <p>{{ trans('feature_disabled') }}</p>
              </div>
            </div>
          @endif

          <div class="col-md-12">
            <div class="table-responsive">
              <table class="display table table-hover">
                <thead>
                  <tr>
                    <th class="col-md-1"></th>
                    <th class="col-md-6">名字</th>
                    <th class="col-md-5">组</th>
                    <th class="col-md-5">资产</th>
                    <th class="col-md-5">附件</th>
                    <th class="col-md-5">许可证</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($users as $user)
                  <tr {!! ($user->isSuperUser() ? ' class="danger"':'') !!}>
                    <td>
                      @if (Auth::id()!=$user->id)
                      <input type="checkbox" name="ids[]" value="{{ $user->id }}" checked="checked">
                      @else
                      <input type="checkbox" name="ids[]" value="{{ $user->id }}" disabled>
                      @endif
                    </td>

                    <td>
                      <span {{ (Auth::user()->id==$user->id ? ' style="text-decoration: line-through"' : '') }}>
                        {{ $user->present()->fullName() }} ({{ $user->username }})
                      </span>
                      {{ (Auth::id()==$user->id ? ' (cannot delete yourself)' : '') }}
                    </td>
                    <td>
                      @foreach ($user->groups as $group)
                      <a href=" {{ route('groups.update', $group->id) }}" class="label  label-default">
                        {{ $group->name  }}
                      </a>&nbsp;
                      @endforeach
                    </td>
                    <td>
                      {{ number_format($user->assets()->count())  }}
                    </td>
                    <td>
                      {{ number_format($user->accessories()->count())  }}
                    </td>
                    <td>
                      {{ number_format($user->licenses()->count())  }}
                    </td>
                  </tr>
                  @endforeach
                </tbody>
                <tfoot>
                  <tr>
                    <td colspan="6" class="warning">
                      {{ Form::select('status_id', $statuslabel_list , Input::old('status_id'), array('class'=>'select2', 'style'=>'width:250px')) }}
                      <label>将这些用户的所有资产更新到该状态</label>
                    </td>
                  </tr>
                  <tr>
                    <td colspan="6" class="warning">
                      <label><input type="checkbox" name="ids['.e($user->id).']" checked> 签入与这些用户相关联的所有属性</label>
                    </td>
                  </tr>
                </tfoot>
              </table>
            </div> <!--/table-responsive-->
          </div><!--/col-md-12-->
        </div> <!--/box-body-->
        <div class="box-footer text-right">
          <a class="btn btn-link" href="{{ URL::previous() }}">{{ trans('button.cancel') }}</a>
          <button type="submit" class="btn btn-success"><i class="fa fa-check icon-white"></i> {{ trans('button.submit') }}</button>
        </div><!-- /.box-footer -->
      </form>
    </div>
  </div>
</div>

@stop
