@extends('layouts/default')

{{-- Page title --}}
@section('title')
Create a User
@parent
@stop

@section('header_right')
<a href="{{ route('users.index') }}" class="btn btn-default"> {{ trans('general.back') }}</a>
@stop

{{-- Page content --}}
@section('content')

<link rel="stylesheet" type="text/css" href="{{ asset('css/lib/jquery.fileupload.css') }}">
<div class="row">
    <div class="col-md-8 col-md-offset-2">
        <form class="form-horizontal" role="form" method="post" enctype="multipart/form-data" action="">
            <div class="box box-default">
                <div class="box-body">

                    @if (config('app.lock_passwords'))
                        <p class="alert alert-warning">上传CSV文件失效.</p>
                    @endif

                    <!-- CSRF Token -->
                    <input type="hidden" name="_token" value="{{ csrf_token() }}" />

                    @if (Session::get('message'))
                    <p class="alert-danger">
                       错误的CSV文件:<br />
                        {{ Session::get('message') }}
                    </p>
                    @endif

                    <p>
                        上传一个或多个用户的CSV文件。 密码自动生成。  CSV文件应该有 <strong>first</strong> 像这样的字段:
                    </p>

                    <p>
                        <strong>firstName,lastName, username, email, location_id, phone, jobtitle, employee_num, company_id</strong>.
                    </p>

                    <p>
                       这些字段右侧的其他字段将被忽略。 电子邮件是可选的，但是如果您不提供电子邮件地址，则用户将无法恢复其密码或接收EULA。 如果你想包括一个公司协会，你必须引用一个现有公司的ID号 - 公司不会凭空创建.
                    </p>




                    <div class="form-group {!! $errors->first('user_import_csv', 'has-error') !!}">
                        <label for="first_name" class="col-sm-3 control-label">{{ trans('admin/users/general.usercsv') }}</label>
                        <div class="col-sm-5">
                            <span class="btn btn-info fileinput-button">
                                    <span>选择导入文件</span>
                                        @if (config('app.lock_passwords'))
                                            <input id="fileupload" type="file" name="user_import_csv" accept="text/csv" disabled="disabled" class="disabled">
                                        @else
                                            <input id="fileupload" type="file" name="user_import_csv" accept="text/csv">
                                        @endif

                                    </span>

                        </div>
                    </div>

                    <!-- Has Headers -->
                    <div class="form-group">
                        <div class="col-sm-2 ">
                        </div>
                        <div class="col-sm-5">
                            {{ Form::checkbox('has_headers', '1', Input::old('has_headers')) }} 
                            CSV文件有标题。
                        </div>
                    </div>

                    <!-- Email user -->
                    <div class="form-group">
                        <div class="col-sm-2">
                        </div>
                        <div class="col-sm-10">
                           向这些用户发送他们的凭据 （只有在用户数据中包含电子邮件地址的情况下才可能）。
                        </div>
                    </div>

                    <!-- Activate -->
                    <div class="form-group">
                        <div class="col-sm-2 ">
                        </div>
                        <div class="col-sm-5">
                            {{ Form::checkbox('activate', '1', Input::old('activate')) }}激活用户？
                        </div>
                    </div>
                </div> <!--/box-body-->
                <!-- Form Actions -->
                <div class="box-footer text-right">

                    @if (config('app.lock_passwords'))
                    <button type="submit" class="btn btn-success disabled" disabled="disabled">{{ trans('button.submit') }}</button>
                    @else
                        <button type="submit" class="btn btn-success">{{ trans('button.submit') }}</button>
                    @endif
                </div>
            </div>
        </form>
    </div>
</div>

@stop
