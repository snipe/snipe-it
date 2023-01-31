<div>
    <div class="row">
        <div class="col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2">
            <div class="panel box box-default">
                 <div class="box-header with-border">
                    <h2 class="box-title">
                        <i class="fab fa-slack"></i> {{ trans('admin/settings/general.slack') }}
                    </h2>
                 </div>
            <div class="box-body">
                <div class="col-md-12" style="border-top: 0px;">
                {{$successMessage}}
                <form wire:submit.prevent ="submit">
                    {{csrf_field()}}
                <div class="form-group required {{ $errors->has('slack_endpoint') ? 'error' : '' }}">
                        <div class="col-md-2">
                            {{ Form::label('slack_endpoint', trans('admin/settings/general.slack_endpoint')) }}
                        </div>
                    <div class="col-md-10">
                        @if (config('app.lock_passwords')===true)
                            {{--                {{ Form::text('slack_endpoint', old('slack_endpoint', $setting->slack_endpoint), array('class' => 'form-control','disabled'=>'disabled','placeholder' => 'https://hooks.slack.com/services/XXXXXXXXXXXXXXXXXXXXX', 'id' => 'slack_endpoint')) }}--}}
                            <p class="text-warning"><i class="fas fa-lock"></i> {{ trans('general.feature_disabled') }}</p>
                            <input type="text" wire:model.defer="slack_endpoint" id="slack_endpoint" class= 'form-control' placeholder="'https://hooks.slack.com/services/XXXXXXXXXXXXXXXXXXXXX'" {{old('slack_endpoint', $slack_endpoint)}} >
                        @else
                            <input type="text" wire:model.defer="slack_endpoint" id="slack_endpoint" class= 'form-control' placeholder="'https://hooks.slack.com/services/XXXXXXXXXXXXXXXXXXXXX'" {{old('slack_endpoint', $slack_endpoint)}} >
                            {{--                {{ Form::text('slack_endpoint', old('slack_endpoint', $setting->slack_endpoint), array('class' => 'form-control','placeholder' => 'https://hooks.slack.com/services/XXXXXXXXXXXXXXXXXXXXX', 'id' => 'slack_endpoint')) }}--}}
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
                        <input type="text" wire:model.defer="slack_channel" id="slack_channel" class= 'form-control' placeholder="'#IT-Ops'" {{old('slack_channel', $slack_channel)}} >
                        <p class="text-warning"><i class="fas fa-lock"></i> {{ trans('general.feature_disabled') }}</p>

                    @else
                        <input type="text" wire:model.defer="slack_channel" id="slack_channel" class= 'form-control' placeholder="'#IT-Ops'" {{old('slack_channel', $slack_channel)}} >
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
                        {{ Form::text('slack_botname', old('slack_botname', $setting->slack_botname), array('class' => 'form-control','disabled'=>'disabled','placeholder' => 'Snipe-Bot')) }}
                        <input type="text" wire:model.defer="slack_botname" id="slack_botname" class= 'form-control' placeholder="'Snipe-Bot'" {{old('slack_botname', $slack_botname)}} >
                        <p class="text-warning"><i class="fas fa-lock"></i> {{ trans('general.feature_disabled') }}</p>

                    @else
                        <input type="text" wire:model.defer="slack_botname" id="slack_botname" class= 'form-control' placeholder="'Snipe-Bot'" {{old('slack_botname', $slack_botname)}} >
                    @endif
                    {!! $errors->first('slack_botname', '<span class="alert-msg" aria-hidden="true">:message</span>') !!}
                </div><!--col-md-10-->
            </div>
            <div class="box-footer">
                <div class="text-left col-md-6">

                    <a class="btn btn-link text-left" href="{{ route('settings.index') }}">{{ trans('button.cancel') }}</a>

                </div>
                <div class="text-right col-md-6">
                    <button type="submit" id="save_slack" class="btn btn-primary"><i class="fas fa-check icon-white" aria-hidden="true"></i> {{ trans('general.save') }}</button>
                </div>
            </div><!--box-footer-->
        </form>

</div> <!--/-->
</div> <!--/.box-body-->

            </div> <!-- /box -->
        </div> <!-- /.col-md-8-->
    </div> <!-- /.row-->

</div>
