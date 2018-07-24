@extends('layouts/edit-form', [
    'createText' => trans('admin/groups/titles.create') ,
    'updateText' => trans('admin/groups/titles.update'),
    'item' => $group,
    'formAction' => ($group !== null && $group->id !== null) ? route('groups.update', ['group' => $group->id]) : route('groups.store'),

])
@section('content')

    <style>
        .form-horizontal .control-label {
            padding-top: 0px;
        }

        input[type='text'][disabled], input[disabled], textarea[disabled], input[readonly], textarea[readonly], .form-control[disabled], .form-control[readonly], fieldset[disabled] .form-control {
            background-color: white;
            color: #555555;
            cursor:text;
        }
        table.permissions {
            display:flex;
            flex-direction: column;
        }

        .permissions.table > thead, .permissions.table > tbody {
            margin: 15px;
            margin-top: 0px;
        }
        .permissions.table > tbody+tbody {

        }
        .header-row {
            border-bottom: 1px solid #ccc;
        }

        .header-row h3 {
            margin:0px;
        }
        .permissions-row {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
        }
        .table > tbody > tr > td.permissions-item {
            padding: 1px;
            padding-left: 8px;
        }

        .header-name {
            cursor: pointer;
        }

    </style>

@parent
@stop

@section('inputFields')
<!-- Name -->
<div class="form-group {{ $errors->has('name') ? ' has-error' : '' }}">
    <label for="name" class="col-md-3 control-label">{{ trans('admin/groups/titles.group_name') }}</label>
    <div class="col-md-6 required">
        <input class="form-control" type="text" name="name" id="name" value="{{ Input::old('name', $group->name) }}" />
        {!! $errors->first('name', '<span class="alert-msg"><i class="fa fa-times"></i> :message</span>') !!}
    </div>
</div>
<div class="col-md-12">

    <table class="table table-striped permissions">
        <thead>
        <tr class="permissions-row">
            <th class="col-md-5">Permission</th>
            <th class="col-md-1">Grant</th>
            <th class="col-md-1">Deny</th>
        </tr>
        </thead>
        <tbody class="permissions-group">
        @foreach ($permissions as $area => $area_permission)
            <!-- handle superadmin and reports, and anything else with only one option -->
            <?php $localPermission = $area_permission[0]; ?>
            @if (count($area_permission) == 1)

                <tr class="header-row permissions-row">
                    <td class="col-md-5 tooltip-base permissions-item"
                        data-toggle="tooltip"
                        data-placement="right"
                        title="{{ $localPermission['note'] }}">
                        <h4>{{ $area . ': ' . $localPermission['label'] }}</h4>
                    </td>
                    <td class="col-md-1 permissions-item">
                        {{ Form::radio('permission['.$localPermission['permission'].']', '1',(array_key_exists($localPermission['permission'], $groupPermissions) ? $groupPermissions[$localPermission['permission'] ] == '1' : null),['value'=>"grant", 'class'=>'minimal']) }}
                    </td>
                    <td class="col-md-1 permissions-item">
                        {{ Form::radio('permission['.$localPermission['permission'].']', '0',(array_key_exists($localPermission['permission'], $groupPermissions) ? $groupPermissions[$localPermission['permission'] ] == '0' : null),['value'=>"grant", 'class'=>'minimal']) }}
                    </td>
                </tr>

            @else

                <tr class="header-row permissions-row">
                    <td class="col-md-5 tooltip-base permissions-item header-name"
                        data-toggle="tooltip"
                        data-placement="right"
                        title="{{ $localPermission['note'] }}">
                        <h4>{{ $area . ': ' . $localPermission['label'] }}</h4>


                    </td>
                    <td class="col-md-1 permissions-item" style="vertical-align: bottom">
                        {{ Form::radio("$area", '1',false,['value'=>"grant", 'class'=>'minimal', 'data-checker-group' => str_slug($area)]) }}
                    </td>
                    <td class="col-md-1 permissions-item">
                        {{ Form::radio("$area", '0',false,['value'=>"deny", 'class'=>'minimal', 'data-checker-group' => str_slug($area)]) }}
                    </td>
                </tr>

                @foreach ($area_permission as $index => $this_permission)
                    @if ($this_permission['display'])
                    <tr class="permissions-row">
                        <td
                                class="col-md-5 tooltip-base permissions-item"
                                data-toggle="tooltip"
                                data-placement="right"
                                title="{{ $this_permission['note'] }}">
                                {{ $this_permission['label'] }}
                        </td>
                        <td class="col-md-1 permissions-item">
                            {{ Form::radio('permission['.$this_permission['permission'].']', '1',(array_key_exists($this_permission['permission'], $groupPermissions) ? $groupPermissions[$this_permission['permission'] ] == '1' : null),['class'=>'minimal radiochecker-'.str_slug($area)]) }}
                        </td>
                        <td class="col-md-1 permissions-item">
                            {{ Form::radio('permission['.$this_permission['permission'].']', '0',(array_key_exists($this_permission['permission'], $groupPermissions) ? $groupPermissions[$this_permission['permission'] ] == '0' : null),['class'=>'minimal radiochecker-'.str_slug($area)]) }}
                        </td>

                    </tr>

                    @endif
                @endforeach

            @endif

        @endforeach
        </tbody>
    </table>

</div>
@stop
@section('moar_scripts')

    <script nonce="{{ csrf_token() }}">

        $(document).ready(function(){

            $('.tooltip-base').tooltip({container: 'body'});
            $(".superuser").change(function() {
                var perms = $(this).val();
                if (perms =='1') {
                    $("#nonadmin").hide();
                } else {
                    $("#nonadmin").show();
                }
            });

            // Check/Uncheck all radio buttons in the group
            $('tr.header-row input:radio').on('ifClicked', function () {
                value = $(this).attr('value');
                area = $(this).data('checker-group');
                $('.radiochecker-'+area+'[value='+value+']').iCheck('check');
            });


            $('.header-name').click(function() {
                $(this).parent().nextUntil('tr.header-row').slideToggle(500);
            });


        });


    </script>
@stop
