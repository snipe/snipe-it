

    <div class="col-md-12" style="border-top: 0px;">
        @if (session()->has('save'))
        <div class="alert alert-success">
            {{session('save')}}
        </div>
        @endif
            @if(session()->has('success'))
                <div class="alert alert-success">
                    {{session('success')}}
                </div>
            @endif
            @if(session()->has('error'))
                <div class="alert alert-danger">
                    {{session('error')}}
                </div>
            @endif
            @if(session()->has('message'))
                <div class="alert alert-danger">
                    {{session('message')}}
                </div>
            @endif
        <form wire:submit.prevent ="submit">
        {{csrf_field()}}

        <!--slack endpoint-->
        <div class="form-group required {{ $errors->has('slack_endpoint') ? 'error' : '' }}">
            <div class="col-md-2">
                {{ Form::label('slack_endpoint', trans('admin/settings/general.slack_endpoint')) }}
            </div>
            <div class="col-md-10">
                @if (config('app.lock_passwords')===true)
{{--                                    {{ Form::text('slack_endpoint', old('slack_endpoint', $setting->slack_endpoint), array('class' => 'form-control','disabled'=>'disabled','placeholder' => 'https://hooks.slack.com/services/XXXXXXXXXXXXXXXXXXXXX', 'id' => 'slack_endpoint')) }}--}}
                    <p class="text-warning"><i class="fas fa-lock"></i> {{ trans('general.feature_disabled') }}</p>
                    <input type="text" wire:model.lazy="slack_endpoint" id="slack_endpoint" class= 'form-control' placeholder="'https://hooks.slack.com/services/XXXXXXXXXXXXXXXXXXXXX'" {{old('slack_endpoint', $slack_endpoint)}} ><br>
                @else
                    <input type="text" wire:model.lazy="slack_endpoint" id="slack_endpoint" class= 'form-control' placeholder="'https://hooks.slack.com/services/XXXXXXXXXXXXXXXXXXXXX'" {{old('slack_endpoint', $slack_endpoint)}} ><br>
{{--                                    {{ Form::text('slack_endpoint', old('slack_endpoint', $setting->slack_endpoint), array('class' => 'form-control','placeholder' => 'https://hooks.slack.com/services/XXXXXXXXXXXXXXXXXXXXX', 'id' => 'slack_endpoint')) }}--}}
                @endif
                {!! $errors->first('slack_endpoint', '<span class="alert-msg" aria-hidden="true">:message</span>') !!}
            </div>
        </div>

        <!-- slack channel -->
        <div class="form-group required {{ $errors->has('slack_channel') ? 'error' : '' }}">
            <div class="col-md-2">
                {{ Form::label('slack_channel', trans('admin/settings/general.slack_channel')) }}
            </div>
            <div class="col-md-10">
                @if (config('app.lock_passwords')===true)
                    <input type="text" wire:model.lazy="slack_channel" id="slack_channel" class='form-control' placeholder="#IT-Ops" value="{{old('slack_channel', $slack_channel)}}" ><br>
                    <p class="text-warning"><i class="fas fa-lock"></i> {{ trans('general.feature_disabled') }}</p>

                @else
                    <input type="text" wire:model.lazy="slack_channel" id="slack_channel" class= 'form-control' placeholder="#IT-Ops" value="{{old('slack_channel', $slack_channel)}}" ><br>
                @endif
                {!! $errors->first('slack_channel', '<span class="alert-msg" aria-hidden="true">:message</span>') !!}
            </div>
        </div>

        <!-- slack botname -->
        <div class="form-group required {{ $errors->has('slack_botname') ? 'error' : '' }}">
            <div class="col-md-2">
                {{ Form::label('slack_botname', trans('admin/settings/general.slack_botname')) }}
            </div>
            <div class="col-md-10">
                @if (config('app.lock_passwords')===true)
{{--                    {{ Form::text('slack_botname', old('slack_botname', $setting->slack_botname), array('class' => 'form-control','disabled'=>'disabled','placeholder' => 'Snipe-Bot')) }}--}}
                    <input type="text" wire:model.lazy="slack_botname" id="slack_botname" class= 'form-control' placeholder="'Snipe-Bot'" {{old('slack_botname', $slack_botname)}} ><br>
                    <p class="text-warning"><i class="fas fa-lock"></i> {{ trans('general.feature_disabled') }}</p>

                @else
                    <input type="text" wire:model.lazy="slack_botname" id="slack_botname" class= 'form-control' placeholder="'Snipe-Bot'" {{old('slack_botname', $slack_botname)}} ><br>
                @endif
                {!! $errors->first('slack_botname', '<span class="alert-msg" aria-hidden="true">:message</span>') !!}
            </div><!--col-md-10-->
        </div>

        <!--Slack Integration Test-->
            @if($slack_endpoint != null && $slack_channel != null && $slack_botname != null)
        <div class="form-group">
                <div class="col-md-2">
                    {{ Form::label('test_slack', 'Test Slack') }}
                </div>
                <div class="col-md-10">
                    <a href="#" wire:click.prevent="testSlack" id="test_slack" class="btn btn-default btn-sm pull-left"><span>{!! trans('admin/settings/general.slack_test') !!}</span></a>
                    <div wire:loading><i class="fas fa-spinner spin"></i></div>
                </div>
        </div>
            @endif

        <div class="box-footer" style="margin-top: 45px;">

            <div class="text-right col-md-12">
                <a class="btn btn-link text-left" href="{{ route('settings.index') }}">{{ trans('button.cancel') }}</a>
                <button type="submit" id="save_slack" class="btn btn-primary"><i class="fas fa-check icon-white" aria-hidden="true"></i> {{ trans('general.save') }}</button>
            </div>
        </div><!--box-footer-->
        </form>

    </div> <!-- /box -->


