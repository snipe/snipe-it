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
      <h4>关于公司</h4>
      <p>
        您可以将公司用作简单的信息字段，也可以通过在管理设置中启用“完全公司支持”来限制资产的可见性和可用性。
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
