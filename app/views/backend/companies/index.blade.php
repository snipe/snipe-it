@extends('backend/layouts/default')

{{-- Page title --}}
@section('title')
@lang('admin/companies/table.companies') ::
@parent
@stop

{{-- Page content --}}
@section('content')

<div class="row header">
  <div class="col-md-12">
    <a href="{{ route('create/company') }}" class="btn btn-success pull-right">
      <i class="fa fa-plus icon-white"></i>
      @lang('general.create')
    </a>
    <h3>@lang('admin/companies/table.companies')</h3>
  </div>
</div>

<div class="user-profile">
  <div class="row profile">

    <div class="col-md-9 bio">

      @if (count($companies) == 0)
        <div class="alert alert-info alert-block">
            <i class="fa fa-info-circle"></i>
            @lang('general.no_results')
        </div>
      @else
        <div class="table-responsive">
          <table class="table">
            <thead>
              <tr>
                <th>@lang('general.id')</th>
                <th>@lang('admin/companies/table.name')</th>
                <th>@lang('table.actions')</th>
              </tr>
              @foreach ($companies as $company)
                <tr>
                  <td>{{{ $company->id }}}</td>
                  <td>{{{ $company->name }}}</td>
                  <td>
                    <form method="POST" action="{{ route('delete/company', $company->id) }}" role="form">

                      <input type="hidden" name="_token" value="{{ csrf_token() }}" />

                      <a href="{{ route('update/company', $company->id) }}" class="btn btn-sm btn-warning"
                         title="{{ Lang::get('button.edit') }}">
                        <i class="fa fa-pencil icon-white"></i>
                      </a>

                      <button type="submit" class="btn btn-sm btn-danger" title="{{ Lang::get('button.delete') }}">
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
        </div>
      @endif

    </div>

    <!-- side address column -->
    <div class="col-md-3 col-xs-12 address pull-right">
      <br>
      <br>
      <h6>Have Some Haiku</h6>
      <p>
        The Staples truck came.<br>
        Left thirteen cardboard boxes.<br>
        Honey stained maple.
      </p>

      <p>----------</p>

      <p>
        I'm sorry, there's – um -<br>
        insufficient – what's-it-called?<br>
        The term eludes me...
      </p>
    </div>
  </div>
</div>

@stop
