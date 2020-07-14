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
            <p class="activ text-center text-bold text-danger hidden">Заполните хотябы один актив</p>
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
            <div class="modal-body2">
                <div class="row">
                    <div class="col-md-12">
                        <form class="form-horizontal">
                            @include ('partials.forms.edit.model-select2', ['translated_name' => trans('admin/hardware/form.model'), 'fieldname' => 'model_id', 'required' => 'true'])
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
    <style>
        .modal-body2 {
            position: relative;
            padding: 15px;
        }
    </style>
@stop

@if (!$item->id)
@section('moar_scripts')
    @include ('partials.bootstrap-table')
<script nonce="{{ csrf_token() }}">


    function fetchCustomFields() {
        //save custom field choices
        var oldvals = $('#custom_fields_content').find('input,select').serializeArray();
        for(var i in oldvals) {
            transformed_oldvals[oldvals[i].name]=oldvals[i].value;
        }

        var modelid = $('#model_select_id').val();
        if (modelid == '') {
            $('#custom_fields_content').html("");
        } else {

            $.ajax({
                type: 'GET',
                url: "{{url('/') }}/models/" + modelid + "/custom_fields",
                headers: {
                    "X-Requested-With": 'XMLHttpRequest',
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr('content')
                },
                _token: "{{ csrf_token() }}",
                dataType: 'html',
                success: function (data) {
                    $('#custom_fields_content').html(data);
                    $('#custom_fields_content select').select2(); //enable select2 on any custom fields that are select-boxes
                    //now re-populate the custom fields based on the previously saved values
                    $('#custom_fields_content').find('input,select').each(function (index,elem) {
                        if(transformed_oldvals[elem.name]) {
                            $(elem).val(transformed_oldvals[elem.name]).trigger('change'); //the trigger is for select2-based objects, if we have any
                        }

                    });
                }
            });
        }
    }

    var table = $('#table');
    $(function() {

        //grab custom fields for this model whenever model changes.
        $('#model_select_id').on("change", fetchCustomFields);

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
        // $('#myModal').on('shown.bs.modal', function () {
        //     console.log('shown.bs.modal');
        // });

        //handle modal-add-interstitial calls
        var model, select;

    $('#myModal').on("show.bs.modal", function (event) {
        // Crazy select2 rich dropdowns with images!
        var link = $(event.relatedTarget);
        model = link.data("dependency");
        select = link.data("select");

        $('#myModal').find('select.select2').select2();
        $('.js-data-ajax2').each( function (i,item) {
            console.log("js-data-ajax createModal")
            var link = $(item);
            var endpoint = link.data("endpoint");
            var select = link.data("select");

            console.log(link)
            console.log(endpoint)
            console.log(select)

            link.select2({
                dropdownParent: $("#myModal"),
                ajax: {

                    // the baseUrl includes a trailing slash
                    url: baseUrl + 'api/v1/' + endpoint + '/selectlist',
                    dataType: 'json',
                    delay: 250,
                    headers: {
                        "X-Requested-With": 'XMLHttpRequest',
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr('content')
                    },
                    data: function (params) {
                        var data = {
                            search: params.term,
                            page: params.page || 1,
                            assetStatusType: link.data("asset-status-type"),
                        };
                        return data;
                    },
                    processResults: function (data, params) {
                        console.log(data)
                        params.page = params.page || 1;

                        var answer =  {
                            results: data.items,
                            pagination: {
                                more: "true" //(params.page  < data.page_count)
                            }
                        };

                        return answer;
                    },
                    cache: true
                },
                escapeMarkup: function (markup) { return markup; }, // let our custom formatter work
                templateResult: formatDatalist,
                templateSelection: formatDataSelection
            });
        });

    });
    function formatDatalist (datalist) {
        var loading_markup = '<i class="fa fa-spinner fa-spin" aria-hidden="true"></i> Loading...';
        if (datalist.loading) {
            return loading_markup;
        }

        var markup = "<div class='clearfix'>" ;
        markup +="<div class='pull-left' style='padding-right: 10px;'>";
        if (datalist.image) {
            markup += "<div style='width: 30px;'><img src='" + datalist.image + "' alt='"+ datalist.tex + "' style='max-height: 20px; max-width: 30px;'></div>";
        } else {
            markup += "<div style='height: 20px; width: 30px;'></div>";
        }

        markup += "</div><div>" + datalist.text + "</div>";
        markup += "</div>";
        return markup;
    }

    function formatDataSelection (datalist) {
        return datalist.text.replace(/>/g, '&gt;')
            .replace(/</g, '&lt;')
            .replace(/"/g, '&quot;')
            .replace(/'/g, '&#039;');
    }

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
            if (data.length>0){
                $('#assets').val(JSON.stringify(data));
                $('.activ').addClass("hidden");
                return true;
            }else{
                $('.activ').removeClass("hidden");
                return false;
            }
        })
    });
</script>
@stop
@endif
