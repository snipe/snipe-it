@extends('backend/layouts/default')

{{-- Page title --}}
@section('title')
  @lang('admin/custom_fields/general.custom_fields')
@parent
@stop

@section('content')

<div class="user-profile">
    <div class="row profile">
        <div class="col-md-9 bio">

          <div class="pull-right">
            <a class="btn btn-info btn-sm" href="{{ route('admin.custom_fields.create') }}">@lang('admin/custom_fields/general.create_fieldset')</a>
          </div>
          <h3>@lang('admin/custom_fields/general.fieldsets')</h3>

            <table
            name="fieldsets"
            id="table" class="table table-responsive table-no-bordered">
                <thead>
                    <tr>
                      <th>@lang('general.name')</th>
                      <th>@lang('admin/custom_fields/general.qty_fields')</th>
                      <th>@lang('admin/custom_fields/general.used_by_models')</th>
                      <th></th>
                    </tr>
                </thead>


                @if(isset($custom_fieldsets))
                <tbody>
                  @foreach($custom_fieldsets AS $fieldset)
                    <tr>
                      <td>
                        {{ link_to_route("admin.custom_fields.show",$fieldset->name,['id' => $fieldset->id]) }}
                      </td>
                      <td>
                          {{ $fieldset->fields->count() }}
                      </td>
                      <td>
                          @foreach($fieldset->models as $model)
                            {{ link_to_route("view/model",$model->name,[$model->id]) }}
                          @endforeach
                      </td>
                      <td>
                          {{ Form::open(array('route' => array('admin.custom_fields.destroy', $fieldset->id), 'method' => 'delete')) }}

                          @if($fieldset->models->count() > 0)
                            <button type="submit" class="btn btn-danger btn-sm disabled" disabled><i class="fa fa-trash"></i></button>
                          @else
                            <button type="submit" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>
                          @endif
                          {{ Form::close() }}
                      </td>
                    </tr>
                  @endforeach
                @endif

              </tbody>
            </table>


            <div class="pull-right">
              <a class="btn btn-info btn-sm" href="{{ route('admin.custom_fields.create-field') }}">@lang('admin/custom_fields/general.create_field')</a>
            </div>

            <h3>@lang('admin/custom_fields/general.custom_fields')</h3>


            <table
            name="fieldsets"
            id="table" class="table table-responsive table-no-bordered">
                <thead>
                    <tr>
                        <th>@lang('general.name')</th>
                        <th>@lang('admin/custom_fields/general.field_format')</th>
                        <th>@lang('admin/custom_fields/general.field_element_short')</th>
                        <th>@lang('admin/custom_fields/general.fieldsets')</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>

                @foreach($custom_fields AS $field)
                  <tr>
                    <td>{{{ $field->name }}}</td>
                    <td>{{{ $field->format }}}</td>
                    <td>{{{ $field->element }}}</td>
                    <td>
                      @foreach($field->fieldset as $fieldset)
                      {{link_to_route("admin.custom_fields.show",$fieldset->name,[$fieldset->id])}}
                      @endforeach
                  </td>
                  <td>
                    {{ Form::open(array('route' => array('admin.custom_fields.delete-field', $field->id), 'method' => 'delete')) }}

                    @if($field->fieldset->count()>0)
                      <button type="submit" class="btn btn-danger btn-sm disabled" disabled><i class="fa fa-trash"></i></button>
                    @else
                      <button type="submit" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>
                    @endif
                    {{ Form::close() }}
                    </td>

                  </tr>
                  @endforeach




              </tbody>
            </table>

        </div>
        <!-- side address column -->
        <div class="col-md-3 col-xs-12 address pull-right">
            <br /><br />
            <h6>@lang('admin/custom_fields/general.about_fieldsets_title')</h6>
            <p>@lang('admin/custom_fields/general.about_fieldsets_text') </p>

        </div>

    </div>
</div>

@stop
