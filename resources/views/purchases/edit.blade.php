@extends('layouts/edit-form', [
    'createText' => "Создать закупку" ,
    'updateText' => "Обновить закупку",
    'formAction' => ($item) ? route('purchases.update', ['purchase' => $item->id]) : route('purchases.store'),
])

{{-- Page content --}}
@section('inputFields')

@include ('partials.forms.edit.invoice_number', ['translated_name' => "Номер счета"])

@include ('partials.forms.edit.final_price', ['translated_name' => "Цена"])

@include ('partials.forms.edit.comment', ['translated_name' => "Комментарий"])

@include ('partials.forms.edit.supplier-select', ['translated_name' => trans('general.supplier'), 'fieldname' => 'supplier_id'])

<!-- Image -->
{{--@if (($item->image) && ($item->image!=''))--}}
{{--    <div class="form-group {{ $errors->has('image_delete') ? 'has-error' : '' }}">--}}
{{--        <label class="col-md-3 control-label" for="image_delete">{{ trans('general.image_delete') }}</label>--}}
{{--        <div class="col-md-5">--}}
{{--            <label for="image_delete">--}}
{{--                {{ Form::checkbox('image_delete', '1', Input::old('image_delete'), array('class' => 'minimal', 'aria-label'=>'required')) }}--}}
{{--            </label>--}}
{{--            <br>--}}
{{--            <img src="{{ url('/') }}/uploads/locations/{{ $item->image }}" alt="Image for {{ $item->name }}">--}}
{{--            {!! $errors->first('image_delete', '<span class="alert-msg" aria-hidden="true"><br>:message</span>') !!}--}}
{{--        </div>--}}
{{--    </div>--}}
{{--@endif--}}

@include ('partials.forms.edit.invoice_file')

<div class="row">
    <div class="col-md-12">
        <div class="table table-responsive">
            <div id="toolbar">
                <div class="button"></div>
                <button type="button" class="btn btn-success"  data-toggle="modal" data-target="#myModal">Добавить</button>
            </div>
            <table id="table" class="table table-striped snipe-table"></table>
        </div><!-- /.table-responsive -->
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Modal title</h4>
            </div>
            <div class="modal-body">
                ...
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
</div>
@stop

@if (!$item->id)
@section('moar_scripts')
    @include ('partials.bootstrap-table')
<script nonce="{{ csrf_token() }}">
    var table = $('#table');
    $(function() {
        var data = [
            {
                'id': 0,
                'name': 'Item 0',
                'price': '$0'
            },
            {
                'id': 1,
                'name': 'Item 1',
                'price': '$1'
            },
            {
                'id': 2,
                'name': 'Item 2',
                'price': '$2'
            },
            {
                'id': 3,
                'name': 'Item 3',
                'price': '$3'
            },
            {
                'id': 4,
                'name': 'Item 4',
                'price': '$4'
            },
            {
                'id': 5,
                'name': 'Item 5',
                'price': '$5'
            }
        ];
        table.bootstrapTable('destroy').bootstrapTable({
            data: data,
            search:true,
            toolbar:'#toolbar',
            columns: [{
                field: 'id',
                name:'id',
                align: 'center',
                valign: 'middle'
            },{
                field: 'name',
                name: 'name',
                align: 'center',
                valign: 'middle'
            }]
        })
    });
</script>
@stop
@endif
