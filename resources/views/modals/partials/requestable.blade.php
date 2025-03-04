<!-- partials/modals/partials/requestable.blade.php -->
<div class="dynamic-form-row" >
    <div class="col-md-offset-4 col-xs-12" style="margin-top:5px;">
        <div style="display: flex; align-items: center;">
            <input
                    type="checkbox"
                    value="1"
                    name="requestable"
                    id="requestable"
                    {{ old('requestable', $item->requestable) == '1' ? 'checked="checked"' : '' }}
                    style="margin-right: 10px;"
            >
            {{ $requestable_text }}
        </div>
    </div>
</div>
<!-- partials/modals/partials/requestable.blade.php -->