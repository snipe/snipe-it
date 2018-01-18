@extends('layouts/default')

{{-- Page title --}}
@section('title')
    Import History
    @parent
@stop

@section('header_right')
    <a href="{{ route('hardware.index') }}" class="btn btn-default"> {{ trans('general.back') }}</a>
@stop

{{-- Page content --}}
@section('content')


    @if (isset($status))

        @if (count($status['error']) > 0)
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <div class="box box-default">
                        <div class="alert alert-danger">
                            <i class="fa fa-exclamation-circle faa-pulse animated"></i>
                            <strong>{{ count($status['error']) }} Error Messagess: </strong>
                           请参阅下面的错误。
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="box box-default">
                    <div class="alert alert-success">
                        <i class="fa fa-check faa-pulse animated"></i>
                        <strong>{{ count($status['success']) }} Success Messages: </strong>
                        请参阅下面的错误。
                    </div>
                </div>
            </div>
        </div>

        @endif

    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="box box-default">
                <div class="box-body">
                    <div class="col-md-12">
                    <form class="form-horizontal" role="form" method="post" enctype="multipart/form-data" action="">
                        <!-- CSRF Token -->
                        <input type="hidden" name="_token" value="{{ csrf_token() }}" />

                        @if (Session::get('message'))
                            <p class="alert-danger">
                                You have an error in your CSV file:<br />
                                {{ Session::get('message') }}
                            </p>
                        @endif

                        <p>
                         上传包含资产历史记录的CSV。 资产和用户必须已经存在于系统中，否则他们将被跳过。 匹配历史记录导入的资产发生在资产标签上。 我们将尝试根据您提供的用户名称以及您在下面选择的条件来查找匹配的用户。 如果您不选择以下任何条件，则只会在您在管理员中配置的用户名上进行匹配 &gt; 通用设置
                        </p>

                        <p>包含在CSV中的字段必须与标题匹配： <strong>日期, 标签, 姓名</strong>. 其他的字段将被忽略 </p>

                        <p><strong>日期</strong>应该是结算日期。 <strong>标签</strong> 应该是资产标签. <strong>姓名</strong> 应该是用户姓名.</p>

                        <p><strong>历史记录应该按照升序排列.</strong></p>

                        <div class="form-group">
                            <label for="first_name" class="col-sm-3 control-label">{{ trans('admin/users/general.usercsv') }}</label>
                            <div class="col-sm-9">
                                <input type="file" name="user_import_csv" id="user_import_csv">
                            </div>
                        </div>




                <!-- Match firstname.lastname -->
                <div class="form-group">
                    <div class="col-sm-2">
                    </div>
                    <div class="col-sm-10">
                        {{ Form::checkbox('match_firstnamelastname', '1', Input::old('match_firstnamelastname')) }} Try to match users by firstname.lastname (jane.smith) format
                    </div>
                </div>

                <!-- Match flastname -->
                <div class="form-group">
                    <div class="col-sm-2">
                    </div>
                    <div class="col-sm-10">
                        {{ Form::checkbox('match_flastname', '1', Input::old('match_flastname')) }} Try to match users by first initial last name (jsmith) format
                    </div>
                </div>

                <!-- Match firstname -->
                <div class="form-group">
                    <div class="col-sm-2">
                    </div>
                    <div class="col-sm-10">
                        {{ Form::checkbox('match_firstname', '1', Input::old('match_firstname')) }} Try to match users by first name (jane) format
                    </div>
                </div>

                <!-- Match email -->
                <div class="form-group">
                    <div class="col-sm-2">
                    </div>
                    <div class="col-sm-10">
                        {{ Form::checkbox('match_email', '1', Input::old('match_email')) }} 请将用户名与邮箱匹配
                    </div>
                </div>


               </div>



        </div>

    <!-- Form Actions -->
    <div class="box-footer text-right">
      <button type="submit" class="btn btn-default">{{ trans('button.submit') }}</button>
    </div>

</form>

 </div>

            @if (isset($status))


                @if (count($status['error']) > 0)
                <div class="row">
                    <div class="col-md-12">
                        <div class="box box-default">
                            <div class="box-header with-border">
                                <h3 class="box-title"> {{ count($status['error']) }} 错误信息</h3>
                            </div>
                            <div class="box-body">
                                <div style="height : 400px; overflow : auto;">
                                    <table class="table">
                                        @for ($x = 0; $x < count($status['error']); $x++)
                                            @foreach($status['error'][$x] as $object_type => $message)
                                            <tr class="danger">
                                                <td><strong>{{ ucwords($object_type)  }} {{ key($message)  }}:</strong></td>
                                                <td>{{ $message[key($message)]['msg']  }}</td>
                                            </tr>
                                            @endforeach
                                        @endfor
                                    </table>
                               </div>
                            </div>
                        </div>
                    </div>
                </div>

                @endif

                @if (count($status['success']) > 0)
                        <div class="row">
                            <div class="col-md-12">
                                <div class="box box-default">
                                    <div class="box-header with-border">
                                        <h3 class="box-title"> {{ count($status['success']) }} 成功信息 </h3>
                                    </div>
                                    <div class="box-body">
                                        <div style="height : 400px; overflow : auto;">
                                            <table class="table">
                                                @for ($x = 0; $x < count($status['success']); $x++)
                                                    @foreach($status['success'][$x] as $object_type => $message)
                                                        <tr class="success">
                                                            <td><strong>{{ ucwords($object_type)  }} {{ key($message)  }}:</strong></td>
                                                            <td>{{ $message[key($message)]['msg']  }}</td>
                                                        </tr>
                                                    @endforeach
                                                @endfor
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                @endif
            @endif

        </div></div></div>
<script nonce="{{ csrf_token() }}">
$(document).ready(function(){

    $('#generate-password').pGenerator({
        'bind': 'click',
        'passwordElement': '#password',
        'displayElement': '#password-display',
        'passwordLength': 10,
        'uppercase': true,
        'lowercase': true,
        'numbers':   true,
        'specialChars': false,

    });
});

</script>
@stop
