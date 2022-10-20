<div>
    <form wire:submit.prevent="save">
    <div class="form-group required {{ $errors->has('slack_endpoint') ? 'error' : '' }}">
        <div class="col-md-2">
            {{ Form::label('slack_endpoint', trans('admin/settings/general.slack_endpoint')) }}
        </div>
        <div class="col-md-10">
            @if (config('app.lock_passwords')===true)
{{--                {{ Form::text('slack_endpoint', old('slack_endpoint', $setting->slack_endpoint), array('class' => 'form-control','disabled'=>'disabled','placeholder' => 'https://hooks.slack.com/services/XXXXXXXXXXXXXXXXXXXXX', 'id' => 'slack_endpoint')) }}--}}
                <p class="text-warning"><i class="fas fa-lock"></i> {{ trans('general.feature_disabled') }}</p>
                <input type="text" wire:model.lazy="setting.slack_endpoint" id="slack_endpoint" class= 'form-control' placeholder="'https://hooks.slack.com/services/XXXXXXXXXXXXXXXXXXXXX'" {{old('slack_endpoint', $setting->slack_endpoint)}} >
            @else
                <input type="text" wire:model.lazy="setting.slack_endpoint" id="slack_endpoint" class= 'form-control' placeholder="'https://hooks.slack.com/services/XXXXXXXXXXXXXXXXXXXXX'" {{old('slack_endpoint', $setting->slack_endpoint)}} >
{{--                {{ Form::text('slack_endpoint', old('slack_endpoint', $setting->slack_endpoint), array('class' => 'form-control','placeholder' => 'https://hooks.slack.com/services/XXXXXXXXXXXXXXXXXXXXX', 'id' => 'slack_endpoint')) }}--}}
            @endif
            {!! $errors->first('slack_endpoint', '<span class="alert-msg" aria-hidden="true">:message</span>') !!}
        </div>
    </div>
    </form>
</div>
