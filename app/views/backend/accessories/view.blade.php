@extends('backend/layouts/default')

{{-- Page title --}}
@section('title')

 {{{ $accessory->name }}}
 @lang('general.accessory') ::
@parent
@stop

{{-- Page content --}}
@section('content')


<div class="row header">
    <div class="col-md-12">
        <div class="btn-group pull-right">
           <a href="{{ URL::previous() }}" class="btn-flat gray pull-right"><i class="fa fa-arrow-left icon-white"></i>  @lang('general.back')</a>        </div>
        <h3>
            {{{ $accessory->name }}}
 @lang('general.accessory')

        </h3>
    </div>
</div>

<div class="user-profile">
<div class="row profile">
<div class="col-md-9 bio">


                            <!-- checked out accessories table -->
                            @if ($accessory->users->count() > 0)
                           <table id="example">
                            <thead>
                                <tr role="row">
                                        <th class="col-md-11">@lang('general.user')</th>
                                        <th class="col-md-1">@lang('table.actions')</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach ($accessory->users as $accessory_users)
                                    <tr>
                                        <td>

                                        <a href="{{ route('view/user', $accessory_users->id) }}">
                                        {{{ $accessory_users->fullName() }}}
                                        
                                        </a>
                                       
                                        </td>
                                        <td>
                                            <a href="{{ route('checkin/accessory', $accessory_users->pivot->id) }}" class="btn-flat info">Checkin</a>
                                        </td>

                                    </tr>
                                    @endforeach


                                </tbody>
                            </table>

                            @else
                            <div class="col-md-9">
                                <div class="alert alert-info alert-block">
                                    <i class="fa fa-info-circle"></i>
                                    @lang('general.no_results')
                                </div>
                            </div>
                            @endif

                        </div>

<!-- side address column -->
<div class="col-md-3 col-xs-12 address pull-right">
    <br /><br />
    <h6>@lang('admin/accessories/general.about_accessories_title')</h6>
    <p>@lang('admin/accessories/general.about_accessories_text') </p>

</div>

@stop
