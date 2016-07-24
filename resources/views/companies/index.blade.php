@extends('layouts/default')

{{-- Page title --}}
@section('title')
{{ trans('admin/companies/table.companies') }}
@parent
@stop

@section('header_right')
<a href="{{ route('create/company') }}" class="btn btn-primary pull-right">
  {{ trans('general.create') }}</a>
@stop

{{-- Page content --}}
@section('content')


<div class="row">
  <div class="col-md-9">
    <div class="box box-default">
      <div class="box-body">
        <div class="table-responsive">
          <table class="table table-striped" name="companies">
            <thead>
              <tr>
                <th class="col-md-1">{{ trans('general.id') }}</th>
                <th class="col-md-9">{{ trans('admin/companies/table.name') }}</th>
                <th class="col-md-2">{{ trans('table.actions') }}</th>
              </tr>
              @foreach ($companies as $company)
                <tr>
                  <td>{{ $company->id }}</td>
                  <td>{{ $company->name }}</td>
                  <td>
                    <form method="POST" action="{{ route('delete/company', $company->id) }}" role="form">

                      <input type="hidden" name="_token" value="{{ csrf_token() }}" />

                      <a href="{{ route('update/company', $company->id) }}" class="btn btn-sm btn-warning"
                         title="{{ trans('button.edit') }}">
                        <i class="fa fa-pencil icon-white"></i>
                      </a>

                      <button type="submit" class="btn btn-sm btn-danger" title="{{ trans('button.delete') }}">
                        <i class="fa fa-trash icon-white"></i>
                      </button>

                    </form>
                  </td>
                </tr>
              @endforeach
            </thead>

            <tbody>
            </tbody>
          </table>
        </div><!-- /.box-body -->
      </div><!-- /.box -->
  </div>
</div>

    <!-- side address column -->
    <div class="col-md-3">
      <h4>About Companies</h4>
      <p>
        You can use companies as a simple placeholder, or you can use them to restrict asset visibility and availability to users with a specific company.
      </p>

    </div>
  </div>
</div>

@stop
