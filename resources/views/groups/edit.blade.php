@extends('layouts/edit-form', [
    'createText' => trans('admin/groups/titles.create') ,
    'updateText' => trans('admin/groups/titles.update'),
    'item' => $group,
    'colspan' => 10,
    'offset' => 1,
    'formAction' => ($group !== null && $group->id !== null) ? route('groups.update', ['group' => $group->id]) : route('groups.store'),

])
@section('content')

@parent
@stop

@section('inputFields')
<!-- Name -->
<div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}" style="padding-bottom: 15px;">
    <label for="name" class="col-md-3 control-label">{{ trans('admin/groups/titles.group_name') }}</label>
    <div class="col-md-6 required">
        <input class="form-control" type="text" name="name" id="name" value="{{ old('name', $group->name) }}" />
        {!! $errors->first('name', '<span class="alert-msg" aria-hidden="true"><i class="fas fa-times" aria-hidden="true"></i> :message</span>') !!}
    </div>
</div>
<div class="col-md-12">

    <div class="row flex-aligned-row">

        @foreach ($permissions as $section => $section_permission)
            <!-- handle superadmin and reports, and anything else with only one option -->
            <?php $localPermission = $section_permission[0]; ?>
            @if (count($section_permission) == 1)


                    <div class="col-md-3 col-lg-3 col-sm-6 col-xl-1">
                        <div class="box box-{{ (($localPermission['permission']=='superuser') ? 'danger' : (($localPermission['permission']=='admin') ? 'warning' : 'default'))  }} flex-aligned-box">
                            <div class="box-body text-center flex-aligned-box">
                                @unless (empty($localPermission['label']))
                                    <h3>{{ $section . ': ' . $localPermission['label'] }}</h3>
                                @else
                                    <h3>{{ $section }}</h3>
                                @endunless
                                    <p class="text-left">{{ $localPermission['note'] }}</p>
                                    <br><br>

                                    <div class="col-md-12 bottom-align-text text-center">
                                        <div class="btn-group" data-toggle="buttons" style="padding-top: 20px; padding-bottom: 20px;">

                                            <label class="btn btn-default">
                                                {{ Form::radio('permission['.$localPermission['permission'].']',
                                                        '1',(array_key_exists($localPermission['permission'], $groupPermissions) ? $groupPermissions[$localPermission['permission'] ] == '1' : null),
                                                        ['id'=> 'permission['.$localPermission['permission'].']',
                                                        'aria-label'=> 'permission['.$localPermission['permission'].']']) }}

                                                <i class="fa fa-check" aria-hidden="true"></i> {{ trans('admin/groups/titles.grant')}}
                                            </label>

                                            <label class="btn btn-danger">
                                                {{ Form::radio('permission['.$localPermission['permission'].']',
                                                    '0',(array_key_exists($localPermission['permission'], $groupPermissions) ? $groupPermissions[$localPermission['permission'] ] == '0' : null),
                                                    ['id'=> 'permission['.$localPermission['permission'].']',
                                                    'aria-label'=> 'permission['.$localPermission['permission'].']']) }}
                                                <i class="fa fa-times" aria-hidden="true"></i> {{ trans('admin/groups/titles.deny')}}
                                            </label>
                                        </div>
                                    </div>


                            </div>
                        </div>
                    </div>
                @endif
        @endforeach
    </div>
</div>

</div>
@stop
@section('moar_scripts')

    <script nonce="{{ csrf_token() }}">

        $(document).ready(function(){

            // Toggle the button states - since this is a bootstrap button group, we have to introspect into the
            // button (which is really a label masquerading as button!) The button group and "button" (label) have no
            // values and the radio button isn't visible, which is why there is all this BS to get the value.

            $(".btn-group > .btn > input[type='radio']").change(function(event) {
                var clickedRadioValue = $(event.target).val();

                if (clickedRadioValue == 1) {
                    $(this).parent().siblings().removeClass("active").removeClass("btn-danger").removeClass("btn-success").addClass('btn-default');
                    $(this).parent().addClass("active").addClass("btn-success").removeClass("btn-danger").removeClass('btn-default');
                } else if (clickedRadioValue == 0) {
                    $(this).parent().siblings().removeClass("active").removeClass("btn-danger").removeClass("btn-success").addClass('btn-default');
                    $(this).parent().addClass("active").addClass("btn-danger").removeClass("btn-success").removeClass('btn-default');
                }

            });




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
