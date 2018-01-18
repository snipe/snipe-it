@if ($errors->any())
<div class="col-md-12">
    <div class="alert alert-danger fade in">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <i class="fa fa-exclamation-circle faa-pulse animated"></i>
        <strong>错误: </strong>
         请检查下面的表格是否有错误 
    </div>
</div>

@endif


@if ($message = Session::get('status'))
    <div class="col-md-12">
        <div class="alert alert-success fade in">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <i class="fa fa-check faa-pulse animated"></i>
            <strong>成功: </strong>
            {{ $message }}
        </div>
    </div>
@endif


@if ($message = Session::get('success'))
<div class="col-md-12">
    <div class="alert alert-success fade in">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <i class="fa fa-check faa-pulse animated"></i>
        <strong>成功： </strong>
        {{ $message }}
    </div>
</div>
@endif

@if ($message = Session::get('error'))
<div class="col-md-12">
    <div class="alert alert alert-danger fade in">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <i class="fa fa-exclamation-circle faa-pulse animated"></i>
        <strong>错误: </strong>
        {{ $message }}
    </div>
</div>
@endif

@if ($message = Session::get('warning'))
<div class="col-md-12">
    <div class="alert alert-warning fade in">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <i class="fa fa-warning faa-pulse animated"></i>
        <strong>警告: </strong>
        {{ $message }}
    </div>
</div>
@endif

@if ($message = Session::get('info'))
<div class="col-md-12">
    <div class="alert alert-info fade in">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <i class="fa fa-info-circle faa-pulse animated"></i>
        <strong>消息: </strong>
        {{ $message }}
    </div>
</div>
@endif
