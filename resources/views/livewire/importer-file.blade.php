  <tr>
    <td colspan="5">
    <div class="col-md-12">

            <div class="row">
                <div class="dynamic-form-row">
                    <div class="col-md-5 col-xs-12">
                        <label for="import-type">Import Type:</label>
                    </div>

                    <div class="col-md-7 col-xs-12">
                        {{ Form::select('activeFile.import_type', $importTypes, $activeFile->import_type, ['id' => 'import_type', 'class' => 'livewire-select2', 'placeholder' => '', 'data-livewire-component' => $_instance->id]) }}
                    </div>

                </div><!-- /dynamic-form-row -->
                <div class="dynamic-form-row">
                    <div class="col-md-5 col-xs-12">
                        <label for="import-update">Update Existing Values?:</label>
                    </div>
                    <div class="col-md-7 col-xs-12" wire:ignore>
                        <input type="checkbox" class="minimal livewire-icheck" name="update" data-livewire-component="{{ $_instance->id }}">
                    </div>
                </div><!-- /dynamic-form-row -->

                <div class="dynamic-form-row">
                    <div class="col-md-5 col-xs-12">
                        <label for="send_welcome">Send Welcome Email for new Users?</label>
                    </div>
                    <div class="col-md-7 col-xs-12" wire:ignore>
                        <input type="checkbox" class="minimal livewire-icheck" name="send_welcome" data-livewire-component="{{ $_instance->id }}">
                    </div>
                </div><!-- /dynamic-form-row -->

                <div class="dynamic-form-row">
                    <div class="col-md-5 col-xs-12">
                        <label for="run_backup">Backup before importing?</label>
                    </div>
                    <div class="col-md-7 col-xs-12" wire:ignore>
                        <input type="checkbox" class="minimal livewire-icheck" name="run_backup" data-livewire-component="{{ $_instance->id }}">
                    </div>
                </div><!-- /dynamic-form-row -->

                @if($statusText)
                <div class="alert col-md-8 col-md-offset-2 {{ $statusType == 'success' ? 'alert-success' : ($statusType == 'error' ? 'alert-danger' : 'alert-info') }}" style="text-align:left">
                    {{ $statusText }}
                </div><!-- /alert -->
                @endif
        </div> <!-- /div row -->

        <div class="row">
            <div class="col-md-12" style="padding-top: 30px;">
                <div class="col-md-4 text-right"><h4>Header Field</h4></div>
                <div class="col-md-4"><h4>Import Field</h4></div>
                <div class="col-md-4"><h4>Sample Value</h4></div>
            </div>
        </div><!-- /div row -->

        @if($activeFile->header_row)
            @foreach($activeFile->header_row AS $index => $header)
                <div class="row" wire:key="header-row-{{ $index }}">
                    <div class="col-md-12">
                        <div class="col-md-4 text-right">
                            <label for="field_map.{{ $index }}" class="control-label">{{ $header }}</label>
                        </div>
                        <div class="col-md-4 form-group">
                            <div required>
                                {{-- this, along with the JS glue below, is quite possibly near to the new Universal LW2 stuff? --}}
                                {{ Form::select('field_map.'.$index, $columnOptions[$activeFile->import_type], @$field_map[$index],
                                    [
                                        'class' => 'mappings livewire-select2',
                                        'placeholder' => 'Do Not Import',
                                        'data-livewire-component' => $_instance->id
                                    ])

                                }}
                            </div>
                        </div>
                        <div class="col-md-4">
                            <p class="form-control-static">{{ $activeFile->first_row[$index] }}</p>
                        </div>
                    </div><!-- /div col-md-8 -->
                </div><!-- /div row -->
            @endforeach
        @else
            No Columns Found!
        @endif

        <div class="row">
            <div class="col-md-6 col-md-offset-2 text-right" style="padding-top: 20px;">
                <button type="button" class="btn btn-sm btn-default" wire:click="$emit('hideDetails')">Cancel</button>
                <button type="submit" class="btn btn-sm btn-primary" id="import">Import</button>
                <br><br>
            </div>
        </div><!-- /div row -->
        <div class="row">
            @if($statusText)
            <div class="alert col-md-8 col-md-offset-2 {{ $statusType == 'success' ? 'alert-success' : ($statusType == 'error' ? 'alert-danger' : 'alert-info') }}"
                 style="padding-top: 20px;"
                 >
                {{ $statusText }}
            </div>
            @endif
        </div><!-- /div row -->

    </div><!-- /div v-show -->

    </td>
  </tr>
<script>
$(function () {
    // initialize iCheck for use with livewire
    $('.minimal.livewire-icheck').iCheck({
        checkboxClass: 'icheckbox_minimal-blue',
    })
})
$('#import').on('click', function () {
    if(!@this.activeFile.import_type) {
        @this.statusType='error';
        @this.statusText= "An import type is required... "; //TODO: translate?
        return;
    }
    @this.statusType='pending';
    @this.statusText = "Processing...";
    @this.generate_field_map().then(function (mappings_raw) {
        var mappings = JSON.parse(mappings_raw)
        console.warn("Here is the mappings:")
        console.dir(mappings)
        $.post({
            url: "{{ route('api.imports.importFile', $activeFile->id) }}",
            data: {
                'import-update': !!@this.update,
                'send-welcome': !!@this.send_welcome,
                'import-type': @this.activeFile.import_type,
                'run-backup': !!@this.run_backup,
                'column-mappings': mappings
            },
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr('content')
            }
        }).done( function (body) {
            // Success
            @this.statusType="success";
            @this.statusText = "Success... Redirecting.";
            console.dir(body)
            window.location.href = body.messages.redirect_url;
        }).fail( function (jqXHR, textStatus, error) {
            // Failure
            var body = jqXHR.responseJSON
            if(body.status == 'import-errors') {
                @this.emit('importError', body.messages);
                @this.statusType='error';
                @this.statusText = "Error";
            } else {
                console.warn("Not import-errors, just regular errors")
                console.dir(body)
                @this.emit('alert', body.error)
            }
            @this.emit('hideDetails')
        });
    })
    return false;
});
</script>