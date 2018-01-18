@extends('layouts/setup')

{{-- Page title --}}
@section('title')
Create a User ::
@parent
@stop

{{-- Page content --}}
@section('content')

<p>此页将进行系统检查，以确保您的配置看起来正确。我们将在下一页添加用户。 </p>

<table class="table">
  <thead>
    <tr>
      <th class="col-lg-2">设置</th>
      <th class="col-lg-1">校验</th>
      <th class="col-lg-9">提醒</th>
    </tr>
  </thead>
  <tbody>
    <tr {!! ($start_settings['url_valid']) ? ' class="success"' : ' class="danger"' !!}>
      <td>URL</td>
      <td>
        @if ($start_settings['url_valid'])
          <i class="fa fa-check preflight-success"></i>
        @else
          <i class="fa fa-times preflight-error"></i>
        @endif
      </td>
      <td>
        @if ($start_settings['url_valid'])
          成功
        @else
          Uh oh! Snipe-IT thinks your URL is {{ $start_settings['url_config'] }}, but your real URL is {{ $start_settings['real_url'] }}
         请升级你的 <code>APP_URL</code> 设置在你的  <code>.env</code> 文件中
        @endif
      </td>
    </tr>

    <tr {!! ($start_settings['db_conn']===true) ? ' class="success"' : ' class="danger"' !!}>
      <td>数据库</td>
      <td>
        @if ($start_settings['db_conn']===true)
          <i class="fa fa-check preflight-success"></i>
        @else
          <i class="fa fa-times preflight-error"></i>
        @endif
      </td>
      <td>
        @if ($start_settings['db_conn']===true)
         成功!连接到 <code>{{ $start_settings['db_name'] }}</code>
        @else
          无法连接到数据库！ 请更新数据库设置在  <code>.env</code>文件中. 数据库显示: <code>{{ $start_settings['db_error'] }}</code>
        @endif
      </td>
    </tr>

    <tr {!! (!$start_settings['env_exposed']) ? ' class="success"' : ' class="danger"' !!}>
      <td>Config File</td>
      <td>
        @if (!$start_settings['env_exposed'])
          <i class="fa fa-check preflight-success"></i>
        @else
          <i class="fa fa-times preflight-error"></i>
        @endif
      </td>
      <td>
        @if (!$start_settings['env_exposed'])
         这不是 <code>.env</code> 文件. (用户可以在浏览器中检查) <a href="../../.env">单击这里检查</a> (这将返回一个未发现或禁止错误的文件。)
        @else
          请检查 <code>.env</code> 通过Web浏览器不能被外界读取。 一个暴露的 <code>.env</code> 文件可以泄露数据库的敏感信息. <a href="../../.env">单价这里检查</a> (这将返回一个未发现或禁止错误的文件)
        @endif
      </td>
    </tr>

    <tr {!! ($start_settings['prod']) ? ' class="success"' : ' class="warning"' !!}>
      <td>环境</td>
      <td>
        @if ($start_settings['prod'])
          <i class="fa fa-check preflight-success"></i>
        @else
          <i class="fa fa-times preflight-error"></i>
        @endif
      </td>
      <td>
        @if ($start_settings['prod'])
         app 在生产模式
        @else
          APP处于 <code>{{ $start_settings['env'] }}</code> 而不是 <code>生产</code> 模式. 如果不在生产模式，请更新<code>APP_ENV</code> 设置  <code>.env</code> 文件至 <code>生产</code>.
        @endif
      </td>
    </tr>

    <tr {!! (!$start_settings['owner_is_admin']) ? ' class="success"' : ' class="danger"' !!}>
      <td>文件持有人</td>
      <td>
        @if (!$start_settings['owner_is_admin'])
          <i class="fa fa-check preflight-success"></i>
        @else
          <i class="fa fa-times preflight-error"></i>
        @endif
      </td>
      <td>
        @if (!$start_settings['owner_is_admin'])
         app归 <code>{{ $start_settings['owner'] }}</code>拥有. 这不像一个默认的账户. 
        @else
          文件归 <code>{{ $start_settings['owner'] }}</code>拥有, 可能是一个管理员账户
        @endif
      </td>
    </tr>

    <tr {!! (!$start_settings['writable']) ? ' class="danger"' : ' class="success"' !!}>
      <td>Permissions</td>
      <td>
        @if ($start_settings['writable'])
          <i class="fa fa-check preflight-success"></i>
        @else
          <i class="fa fa-times preflight-error"></i>
        @endif
      </td>
      <td>
        @if ($start_settings['writable'])
         你的存储地址是可写的
        @else
          Uh-oh. Your <code>{{ storage_path() }}</code> directory (or sub-directories within) are not writable by the web-server. Those directories need to be writable by the web server in order for the app to work.
        @endif
      </td>
    </tr>

    <tr {!! ($start_settings['debug_exposed']) ? ' class="danger"' : ' class="success"' !!}>
      <td>Debug</td>
      <td>
        @if (!$start_settings['debug_exposed'])
          <i class="fa fa-check preflight-success"></i>
        @else
          <i class="fa fa-times preflight-error"></i>
        @endif
      </td>
      <td>
        @if (!$start_settings['debug_exposed'])
           调试是关闭的，或你运行在非生产环境中。
        @else
        你应该关闭调试模式. 请更新你的<code>APP_DEBUG</code> 设置在  <code>.env</code> 文件夹
        @endif
      </td>
    </tr>

    <tr {!! ($start_settings['gd']) ? ' class="success"' : ' class="warning"' !!}>
      <td>Image Library</td>
      <td>
        @if ($start_settings['gd'])
          <i class="fa fa-check preflight-success"></i>
        @else
          <i class="fa fa-times preflight-warning"></i>
        @endif
      </td>
      <td>
        @if ($start_settings['gd'])
          GD 已被安装. 
        @else
          GD未被安装
        @endif
      </td>
    </tr>

    <tr id="mailtestrow" class="warning">
      <td>电子邮件</td>
      <td>
            <a class="btn btn-default btn-sm pull-left" id="mailtest" style="margin-right: 10px;">
                发送测试</a>
      </td>
        <td>
            <span id="mailtesticon"></span>
            <span id="mailtestresult"></span>
            <span id="mailteststatus"></span>
            <div class="col-md-12">
                <div id="mailteststatus-error" class="text-danger"></div>
            </div>
            <div class="col-md-12">
                <p class="help-block">尝试发送邮件 {{ config('mail.from.address') }}.</p>
            </div>
      </td>
    </tr>
  </tbody>
</table>

@stop

@section('button')
  <form action="{{ route('setup.migrate') }}" method="GET">
    <button class="btn btn-primary">下一步：创建数据库表</button>
  </form>
@parent
@stop

@section('moar_scripts')
<script type="text/javascript">
    $(document).ready(function () {

        // Test Mail

        $("#mailtest").click(function(){

            $("#mailtestrow").removeClass('success').removeClass('danger').removeClass('warning');
            $("#mailtestrow").addClass('info');
            $("#mailtesticon").html('');
            $("#mailteststatus").html('');
            $('#mailteststatus-error').html('');
            $("#mailtesticon").html('<i class="fa fa-spinner spin"></i> Sending Test Email...');

            $.ajax({
                url: "{{ route('setup.mailtest') }}",

                success: function (result) {
                    if (result.status == 'success') {
                        $("#mailtestrow").removeClass('info').removeClass('danger').removeClass('warning');
                        $("#mailtestrow").addClass('success');
                        $("#mailtesticon").html('');
                        $("#mailteststatus").html('');
                        $('#mailteststatus-error').html('');
                        $("#mailteststatus").removeClass('text-danger');
                        $("#mailteststatus").addClass('text-success');
                        $("#mailteststatus").html('<i class="fa fa-check text-success"></i> Mail sent to {{ config('mail.from.address') }}!');
                    } else {
                        $("#mailtestrow").removeClass('success').removeClass('info').removeClass('warning');
                        $("#mailtestrow").addClass('danger');
                        $("#mailtesticon").html('<i class="fa fa-check preflight-error"></i>');
                        $("#mailtestresult").html('Something went wrong. Your email was not sent. Check your mail settings in your <code>.env</code> file.');

                    }


                },
                error: function (result) {
                    $("#mailtestrow").removeClass('success').removeClass('info').removeClass('warning');
                    $("#mailtestrow").addClass('danger');
                    $("#mailtesticon").html('');
                    $("#mailteststatus").html('');
                    $('#mailteststatus-error').html('');
                    $("#mailteststatus").removeClass('text-success');
                    $("#mailteststatus").addClass('text-danger');
                    $("#mailtesticon").html('<i class="fa fa-exclamation-triangle text-danger"></i>');
                    $('#mailteststatus').html('Mail could not be sent.');
                    if (result.responseJSON) {
                        $('#mailteststatus-error').html('Error: ' + result.responseJSON.messages);
                    } else {
                        console.dir(data);
                    }
                }

            });


        });
 });
</script>
@stop
