@extends('layouts/edit-form', [
    'createText' => "Создать закупку" ,
    'updateText' => "Обновить закупку",
    'formAction' => ($item) ? route('purchases.update', ['purchase' => $item->id]) : route('purchases.store'),
])

{{-- Page content --}}
@section('inputFields')

@include ('partials.forms.edit.invoice_number', ['translated_name' => "Название"])

@include ('partials.forms.edit.final_price', ['translated_name' => "Цена"])

@include ('partials.forms.edit.currency-select', ['translated_name' => "Валюта", 'fieldname' => 'currency_id'])

@include ('partials.forms.edit.comment', ['translated_name' => "Комментарий"])

@include ('partials.forms.edit.supplier-select', ['translated_name' => trans('general.supplier'), 'fieldname' => 'supplier_id'])

@include ('partials.forms.edit.invoice-type-select', ['translated_name' => "Тип счета", 'fieldname' => 'invoice_type_id'])

@include ('partials.forms.edit.legal_person-select', ['translated_name' => "Юр. лицо", 'fieldname' => 'legal_person_id'])


@include ('partials.forms.edit.invoice_file')
<input type="hidden" id="assets" name="assets" value="">

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
@stop

@section('content')
    @parent
<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Добавить</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <form>
                            @include ('partials.forms.edit.model-select', ['translated_name' => trans('admin/hardware/form.model'), 'fieldname' => 'model_id', 'required' => 'true'])
                            <p class="duble text-center text-bold text-danger hidden">Такая модель уже есть</p>
                            @include ('partials.forms.edit.purchase_cost')
                            @include ('partials.forms.edit.nds')
                            @include ('partials.forms.edit.warranty')
                            @include ('partials.forms.edit.quantity')
                        </form>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
                <button type="button" class="btn btn-primary" id="modalAdd">Добавить</button>
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
        $('.js-data-no-ajax').each( function (i,item) {
            var link = $(item);
            console.log(link);
            link.select2();
        });
        var data = [];
        table.bootstrapTable('destroy').bootstrapTable({
            data: data,
            search:true,
            toolbar:'#toolbar',
            columns: [{
                field: 'id',
                name:'#',
                align: 'left',
                valign: 'middle'
            },{
                field: 'model',
                name:'Модель',
                align: 'left',
                valign: 'middle'
            },{
                field: 'purchase_cost',
                name: 'Закупочная цена',
                align: 'center',
                valign: 'middle'
            },{
                field: 'nds',
                name: 'НДС',
                align: 'center',
                valign: 'middle'
            },{
                field: 'warranty',
                name: 'Гарантия',
                align: 'center',
                valign: 'middle',
            },{
                field: 'quantity',
                name: 'Количество',
                align: 'center',
                valign: 'middle'
            },{
                align: 'center',
                valign: 'middle',
                events: {
                    'click .remove': function (e, value, row, index) {
                        table.bootstrapTable('remove', {
                            field: 'id',
                            values: [row.id]
                        });
                        var data = table.bootstrapTable('getData');
                        var newData = [];
                        var count = 0 ;
                        data.forEach(function callback(currentValue, index, array) {
                            count++;
                            currentValue.id = count;
                            newData.push(currentValue);
                        });
                        table.bootstrapTable('load',newData);
                    }
                },
                formatter: function (value, row, index) {
                    return [
                        '<a class="remove text-danger"  href="javascript:void(0)" title="Убрать">',
                        '<i class="remove fa fa-times fa-lg"></i>',
                        '</a>'
                    ].join('')
                }
            }]
        });
        var count = 0;
        $('#modalAdd').click(function(e){
            e.preventDefault();
            var model_id = $('select[name=model_id] option').filter(':selected').val();
            var model_name = $('select[name=model_id] option').filter(':selected').text();
            var data = table.bootstrapTable('getData');
            if (model_id>0){
                var rez = true;
                data.forEach(function callback(currentValue, index, array) {
                    if (currentValue.model_id == model_id){
                        rez = false;
                    }
                });
                if(rez) {
                    count++;
                    data = {
                        id: count,
                        model_id: model_id,
                        model: model_name,
                        purchase_cost: $('#purchase_cost').val(),
                        nds: $('#nds').val(),
                        warranty: $('#warranty_months').val(),
                        quantity: $('#quantity').val(),
                    };
                    table.bootstrapTable('append', data);
                    $('#myModal').modal('hide');
                    $('.duble').addClass('hidden');
                }else{
                    $('.duble').removeClass('hidden');
                }
            }else{
                $("#model_id").addClass("has-error");
            }
        });
        $('#myModal').on('show.bs.modal', function (event) {
            var modal = $(this);
            $("#model_id").removeClass("has-error");
            $("#model_select_id").val('');
            $('#model_select_id').trigger('change');
            modal.find('#purchase_cost').val('');
            modal.find('#nds').val(20);
            modal.find('#warranty_months').val(12);
            modal.find('#quantity').val(1);
            $('.duble').addClass('hidden');
        })
        $("#create-form").on("submit", function(){
            var data = table.bootstrapTable('getData');
            $('#assets').val(JSON.stringify(data));

            console.log(JSON.stringify(data));
            return true;
        })
    });
</script>
@stop
@endif
