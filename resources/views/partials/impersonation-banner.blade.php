@if (!empty($impersonator) && Auth::check())
    <div class="row" role="alert" aria-live="polite" style="margin-bottom: 0px;">
        <div class="col-md-12" style="background-color: #b94a48; color: #ffffff; padding: 20px 30px 14px 30px; font-size: 17px;">
            <x-icon type="impersonate" class="pull-left" style="margin-right: 15px; margin-top: 2px;"/>
            <strong>{{ trans('admin/users/general.impersonating_banner_title') }}</strong>
            {{ trans('admin/users/general.impersonating_banner_text', ['name' => Auth::user()->display_name, 'impersonator' => $impersonator->display_name]) }}
            <form action="{{ route('users.impersonate.stop') }}" method="POST" class="form-inline pull-right" style="display: inline;">
                {{ csrf_field() }}
                <button type="submit" class="btn btn-sm btn-default" style="background-color: #ffffff; border-color: #ffffff; font-weight: bold;">
                    <x-icon type="undo" class="fa-fw"/>
                    {{ trans('admin/users/general.impersonating_stop_link', ['name' => $impersonator->display_name]) }}
                </button>
            </form>
        </div>
    </div>
@endif
