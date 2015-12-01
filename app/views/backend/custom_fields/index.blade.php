@extends('backend/layouts/default')
@section('content')



<h3>Fieldsets</h3>

<div class="user-profile">
    <div class="row profile">
        <div class="col-md-12">
            <table
            name="fieldsets"
            id="table" class="table table-responsive table-no-bordered">
                <thead>
                    <tr>
                      <th>@lang('general.name')</th>
                      <th></th>
                    </tr>
                </thead>
                <tfoot>
                  <tr>
                    <td colspan="2" class="text-right">
                      <a class="btn btn-info btn-sm" href="{{ route('admin.custom_fields.create') }}">New Fieldset</a>
                    </td>
                  </tr>
                </tfoot>

                @if(isset($custom_fieldsets))
                <tbody>
                  @foreach($custom_fieldsets AS $fieldset)
                    <tr>
                      <td>{{ link_to_route("admin.custom_fields.show",$fieldset->name,['id' => $fieldset->id]) }}
                      </td>
                    <td>
                      @if($fieldset->models->count() > 0)
                        Fieldset in use in models:
                        @foreach($fieldset->models AS $model)
                          {{link_to_route("view/model",$model->name,[$model->id])}}
                        @endforeach
                      @else
                        {{ Form::open(array('route' => array('admin.custom_fields.destroy', $fieldset->id), 'method' => 'delete')) }}
                        <button type="submit" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>
                        {{ Form::close() }}</li>
                      @endif
                    </td></tr>
                  @endforeach
                @endif

              </tbody>
            </table>


            <h3>Custom Field Definitions</h3>

            <table
            name="fieldsets"
            id="table" class="table table-responsive table-no-bordered">
                <thead>
                    <tr>
                        <th>@lang('general.name')</th>
                        <th>Type</th>
                        <th>Fieldsets</th>
                        <th></th>
                    </tr>
                </thead>
                <tfoot>
                  <tr>
                    <td colspan="4" class="text-right">
                      <a class="btn btn-info btn-sm" href="{{ route('admin.custom_fields.create-field') }}">New Field</a>
                    </td>
                  </tr>
                </tfoot>
                <tbody>

                @foreach($custom_fields AS $field)
                  <tr>
                    <td>{{{ $field->name }}}</td>
                    <td>{{{ $field->format }}}</td>
                    <td>

                    @if($field->fieldset->count()>0)

                      @foreach($field->fieldset as $fieldset)
                      {{link_to_route("admin.custom_fields.show",$fieldset->name,[$fieldset->id])}}
                      @endforeach
                    @endif
                  </td>
                  <td>

                    @if($field->fieldset->count()==0)

                      {{ Form::open(array('route' => array('admin.custom_fields.delete-field', $field->id), 'method' => 'delete')) }}
                      <button type="submit" class="btn btn-danger btn-mini">Delete</button>
                      {{ Form::close() }}</td>
                    @endif
                    </td>
                  </tr>
                  @endforeach




              </tbody>
            </table>

        </div>

    </div>
</div>

@stop
