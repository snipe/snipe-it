@extends('layouts/default')

{{-- Page title --}}
@section('title')
    {{ trans('admin/settings/general.slack_title') }}
    @parent
@stop

@section('header_right')
    <a href="{{ route('settings.index') }}" class="btn btn-primary"> {{ trans('general.back') }}</a>
@stop


{{-- Page content --}}
@section('content')

    <style>
        .checkbox label {
            padding-right: 40px;
        }
    </style>

    <div class="row">
        <div class="col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2">

            <div class="panel box box-default">
                <div class="box-header with-border">
                    <h2 class="box-title">
                        <i class="fab fa-slack"></i> {{ trans('admin/settings/general.slack') }}
                    </h2>
                </div>
                <div class="box-body">

                    <p style="padding: 20px;">
                        {!! trans('admin/settings/general.slack_integration_help',array('slack_link' => 'https://my.slack.com/services/new/incoming-webhook')) !!}
                    </p>

                    @livewire('slack-settings-form')

        </div> <!-- /.col-md-8-->
    </div> <!-- /.row-->


@stop






