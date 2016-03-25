@extends('layouts/default')

{{-- Page title --}}
@section('title')
  Manage {{ trans('admin/custom_fields/general.custom_fields') }}
@parent
@stop

@section('content')


  <div class="row">
    <div class="col-md-9">

      <div class="box box-default">

          <div class="box-header with-border">
            <h3 class="box-title">{{ trans('admin/custom_fields/general.fieldsets') }}</h3>
            <div class="box-tools pull-right">
              <a href="{{ route('admin.custom_fields.create') }}" class="btn btn-sm btn-primary" data-toggle="tooltip" title="Create a new fieldset">{{ trans('admin/custom_fields/general.create_fieldset') }}</a>
            </div>
          </div><!-- /.box-header -->
         <div class="box-body">
           <table
               name="fieldsets"
               id="table" class="table table-responsive table-no-bordered">
                   <thead>
                       <tr>
                         <th>{{ trans('general.name') }}</th>
                         <th>{{ trans('admin/custom_fields/general.qty_fields') }}</th>
                         <th>{{ trans('admin/custom_fields/general.used_by_models') }}</th>
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

        </div><!-- /.box-body -->
      </div><!-- /.box -->

    </div>
    <!-- side address column -->
    <div class="col-md-3">
        <h4>{{ trans('admin/custom_fields/general.about_fieldsets_title') }}</h4>
        <p>{{ trans('admin/custom_fields/general.about_fieldsets_text') }} </p>

    </div>
</div>

<div class="row">
  <div class="col-md-9">

    <div class="box box-default">

        <div class="box-header with-border">
          <h3 class="box-title">{{ trans('admin/custom_fields/general.custom_fields') }}</h3>
          <div class="box-tools pull-right">
            <a href="{{ route('admin.custom_fields.create-field') }}" class="btn btn-sm btn-primary" data-toggle="tooltip" title="Create a new custom field">{{ trans('admin/custom_fields/general.create_field') }}</a>
          </div>
        </div><!-- /.box-header -->
       <div class="box-body">

         <table
         name="fieldsets"
         id="table" class="table table-responsive table-no-bordered">
             <thead>
                 <tr>
                     <th>{{ trans('general.name') }}</th>
                     <th>{{ trans('admin/custom_fields/general.field_format') }}</th>
                     <th>{{ trans('admin/custom_fields/general.field_element_short') }}</th>
                     <th>{{ trans('admin/custom_fields/general.fieldsets') }}</th>
                     <th></th>
                 </tr>
             </thead>
             <tbody>

             @foreach($custom_fields AS $field)
               <tr>
                 <td>{{ $field->name }}</td>
                 <td>{{ $field->format }}</td>
                 <td>{{ $field->element }}</td>
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


      </div><!-- /.box-body -->
    </div><!-- /.box -->

  </div>



    </div>
</div>

@stop
