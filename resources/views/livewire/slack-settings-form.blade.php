

    <div class="col-md-12" style="border-top: 0px;">
        @if (session()->has('save'))
        <div class="alert alert-success fade in">
            {{session('save')}}
        </div>
        @endif

        @if(session()->has('success'))
            <div class="alert alert-success fade in">
                {{session('success')}}
            </div>
        @endif
        @if(session()->has('error'))
            <div class="alert alert-danger fade in">
                {{session('error')}}
            </div>
        @endif
        @if(session()->has('message'))
            <div class="alert alert-danger fade in">
                {{session('message')}}
            </div>
        @endif

        <form class="form-horizontal" role="form" wire:submit.prevent="submit">
        {{csrf_field()}}

        <!--slack endpoint-->
        <div class="form-group{{ $errors->has('slack_endpoint') ? ' error' : '' }}">
            <div class="col-md-2">
                {{ Form::label('slack_endpoint', trans('admin/settings/general.slack_endpoint')) }}
            </div>
            <div class="col-md-8 required">
                @if (config('app.lock_passwords')===true)
                    <p class="text-warning"><i class="fas fa-lock"></i> {{ trans('general.feature_disabled') }}</p>
                    <input type="text" wire:model="slack_endpoint" class= 'form-control' placeholder="https://hooks.slack.com/services/XXXXXXXXXXXXXXXXXXXXX" {{old('slack_endpoint', $slack_endpoint)}}>
                @else
                    <input type="text" wire:model="slack_endpoint" class= 'form-control' placeholder="https://hooks.slack.com/services/XXXXXXXXXXXXXXXXXXXXX" {{old('slack_endpoint', $slack_endpoint)}}>
                @endif
                {!! $errors->first('slack_endpoint', '<span class="alert-msg" aria-hidden="true">:message</span>') !!}
            </div>
        </div>

        <!-- slack channel -->
        <div class="form-group{{ $errors->has('slack_channel') ? ' error' : '' }}">
            <div class="col-md-2">
                {{ Form::label('slack_channel', trans('admin/settings/general.slack_channel')) }}
            </div>
            <div class="col-md-8 required">
                @if (config('app.lock_passwords')===true)
                    <input type="text" wire:model="slack_channel" class='form-control' placeholder="#IT-Ops" value="{{old('slack_channel', $slack_channel)}}">
                    <p class="text-warning"><i class="fas fa-lock"></i> {{ trans('general.feature_disabled') }}</p>

                @else
                    <input type="text" wire:model="slack_channel" class= 'form-control' placeholder="#IT-Ops" value="{{old('slack_channel', $slack_channel)}}">
                @endif
                {!! $errors->first('slack_channel', '<span class="alert-msg" aria-hidden="true">:message</span>') !!}
            </div>
        </div>

        <!-- slack botname -->
        <div class="form-group{{ $errors->has('slack_botname') ? ' error' : '' }}">
            <div class="col-md-2">
                {{ Form::label('slack_botname', trans('admin/settings/general.slack_botname')) }}
            </div>
            <div class="col-md-8">
                @if (config('app.lock_passwords')===true)
                    <input type="text" wire:model="slack_botname" class= 'form-control' placeholder="Snipe-Bot" {{old('slack_botname', $slack_botname)}}>
                    <p class="text-warning"><i class="fas fa-lock"></i> {{ trans('general.feature_disabled') }}</p>

                @else
                    <input type="text" wire:model="slack_botname" class= 'form-control' placeholder="Snipe-Bot" {{old('slack_botname', $slack_botname)}}>
                @endif
                {!! $errors->first('slack_botname', '<span class="alert-msg" aria-hidden="true">:message</span>') !!}
            </div><!--col-md-10-->
        </div>

        <!--Slack Integration Test-->
            @if($slack_endpoint != null && $slack_channel != null)
        <div class="form-group">
                <div class="col-md-offset-2 col-md-8">
                    <a href="#" wire:click.prevent="testSlack" class="btn btn-default btn-sm pull-left"><span>{!! trans('admin/settings/general.slack_test') !!}</span></a>
                    <div wire:loading><span style="padding-left: 5px; font-size: 20px"><i class="fas fa-spinner fa-spin"></i></span></div>
                </div>
        </div>
            @endif

        <div class="box-footer" style="margin-top: 45px;">
            <div class="text-right col-md-12">
                <a class="btn btn-link text-left" href="{{ route('settings.index') }}">{{ trans('button.cancel') }}</a>
                <button type="submit" {{$isDisabled}} class="btn btn-primary"><i class="fas fa-check icon-white" aria-hidden="true"></i> {{ trans('general.save') }}</button>
            </div>
        </div><!--box-footer-->
        </form>

    </div> <!-- /box -->


