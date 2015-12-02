@extends('backend/layouts/default')
@section('content')

<div class="user-profile">
    <div class="row profile">
        <div class="col-md-9 bio">

          <div class="pull-right">
            <a class="btn btn-info btn-sm" href="{{ route('admin.custom_fields.create') }}">New Fieldset</a>
          </div>
          <h3>Fieldsets</h3>

            <table
            name="fieldsets"
            id="table" class="table table-responsive table-no-bordered">
                <thead>
                    <tr>
                      <th>@lang('general.name')</th>
                      <th>Used By Models</th>
                      <th></th>
                    </tr>
                </thead>


                @if(isset($custom_fieldsets))
                <tbody>
                  @foreach($custom_fieldsets AS $fieldset)
                    <tr>
                      <td>{{ link_to_route("admin.custom_fields.show",$fieldset->name,['id' => $fieldset->id]) }}
                      </td>
                    <td>
                        @foreach($fieldset->models as $model)
                          {{link_to_route("view/model",$model->name,[$model->id])}}
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
              <a class="btn btn-info btn-sm" href="{{ route('admin.custom_fields.create-field') }}">New Field</a>
            </div>

            <h3>Custom Field Definitions</h3>


            <table
            name="fieldsets"
            id="table" class="table table-responsive table-no-bordered">
                <thead>
                    <tr>
                        <th>@lang('general.name')</th>
                        <th>@lang('admin/custom_fields/general.field_format')</th>
                        <th>Fieldsets</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>

                @foreach($custom_fields AS $field)
                  <tr>
                    <td>{{{ $field->name }}}</td>
                    <td>{{{ $field->format }}}</td>
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
