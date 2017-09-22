@extends('layouts/default')

{{-- Page title --}}
@section('title')
  {{ trans('general.companies') }}
  @parent
@stop

@section('header_right')
  <a href="{{ route('companies.create') }}" class="btn btn-primary pull-right">
    {{ trans('general.create') }}</a>
@stop
{{-- Page content --}}
@section('content')
  <div class="row">
    <div class="col-md-9">
      <div class="box box-default">
        <div class="box-body">
          <div class="table-responsive">
            <table
                    name="companies"
                    class="table table-striped snipe-table"
                    id="table"
                    data-url="{{ route('api.companies.index') }}"
                    data-cookie="true"
                    data-click-to-select="true"
                    data-cookie-id-table="companiesTable-{{ config('version.hash_version') }}">
            </table>
          </div>
        </div>
      </div>
    </div>
    <!-- side address column -->
    <div class="col-md-3">
      <h4>About Companies</h4>
      <p>
        You can use companies as a simple informative field, or you can use them to restrict asset visibility and availability to users with a specific company by enabling Full Company Support in your Admin Settings.
      </p>
  </div>

@stop

@section('moar_scripts')
  @include ('partials.bootstrap-table', [
      'exportFile' => 'companies-export',
      'search' => true,
      'columns' => \App\Presenters\CompanyPresenter::dataTableLayout()
  ])

@stop
