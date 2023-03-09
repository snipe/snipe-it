
            <div class="col-md-12">

                <div class="form-group col-md-12">

                    <label for="activeFile.import_type" class="col-md-3 col-xs-12 text-right">
                        Import Type
                    </label>

                    <div class="col-md-9 col-xs-12">
                        {{ Form::select('activeFile.import_type', $importTypes, $activeFile->import_type, [
                            'id' => 'import_type',
                            'class' => 'livewire-select2',
                            'style' => 'min-width: 350px',
                            'data-placeholder' => trans('general.select_var', ['thing' => trans('general.import_type')]), /* TODO: translate me */
                            'placeholder' => '', //needed so that the form-helper will put an empty option first
                            'data-minimum-results-for-search' => '-1', // Remove this if the list gets long enough that we need to search
                            'data-livewire-component' => $_instance->id
                        ]) }}
                    </div>
                </div>

                <div class="form-group col-md-12">
                    <label for="update" class="col-md-9 col-md-offset-3 col-xs-12" wire:ignore>
                        <input type="checkbox" class="minimal livewire-icheck" name="update" data-livewire-component="{{ $_instance->id }}">
                            Update Existing Values?
                    </label>
                </div>

                <div class="form-group col-md-12">
                    <label for="send_welcome" class="col-md-9 col-md-offset-3 col-xs-12" wire:ignore>
                            <input type="checkbox" class="minimal livewire-icheck" name="send_welcome" data-livewire-component="{{ $_instance->id }}">
                         Send Welcome Email for new Users?
                    </label>
                </div>

                <div class="form-group col-md-12">
                    <label for="run_backup" class="col-md-9 col-md-offset-3 col-xs-12" wire:ignore>
                        <input type="checkbox" class="minimal livewire-icheck" name="run_backup" data-livewire-component="{{ $_instance->id }}">
                        Backup before importing?
                    </label>
                </div>


                @if ($statusText)
                    <div class="form-group">
                        <div class="alert col-md-8 col-md-offset-2 {{ $statusType == 'success' ? 'alert-success' : ($statusType == 'error' ? 'alert-danger' : 'alert-info') }}" style="text-align:left">
                            {{ $statusText }}
                        </div><!-- /alert -->
                    </div>
                @endif


        @if ($activeFile->import_type)
            <div class="form-group col-md-12">
                <hr style="border-top: 1px solid lightgray">
                <h3><i class="{{ Helper::iconTypeByItem($activeFile->import_type) }}"></i> Map {{ ucwords($activeFile->import_type) }} Import Fields</h3>
                <hr style="border-top: 1px solid lightgray">
            </div>
            <div class="form-group col-md-12">
                <div class="col-md-3 text-right">
                    <strong>CSV Header Field</strong>
                </div>
                <div class="col-md-4">
                    <strong>Import Field</strong>
                </div>
                <div class="col-md-5">
                    <strong>Sample Value</strong>
                </div>
            </div><!-- /div row -->

            @if($activeFile->header_row)

                @foreach($activeFile->header_row as $index => $header)

                    <div class="form-group col-md-12" wire:key="header-row-{{ $index }}">

                            <label for="field_map.{{ $index }}" class="col-md-3 control-label text-right">{{ $header }}</label>
                            <div class="col-md-4">

                                    {{ Form::select('field_map.'.$index, $columnOptions[$activeFile->import_type], @$field_map[$index],
                                        [
                                            'class' => 'mappings livewire-select2',
                                            'placeholder' => 'Do Not Import',
                                            'style' => 'min-width: 100%',
                                            'data-livewire-component' => $_instance->id
                                        ],[
                                            '-' => ['disabled' => true] // this makes the "-----" line unclickable
                                        ])
                                    }}
                            </div>
                            <div class="col-md-5">
                                <p class="form-control-static">{{ str_limit($activeFile->first_row[$index], 50, '...') }}</p>
                            </div>
                    </div><!-- /div row -->
                @endforeach
            @else
                No Columns Found!
            @endif

                <div class="form-group col-md-12">
                    <div class="col-md-3 text-left">
                        <a href="#" wire:click="$emit('hideDetails')">{{ trans('general.cancel') }}</a>
                    </div>
                     <div class="col-md-9">
                        <button type="submit" class="btn btn-primary col-md-5" id="import">Import</button>
                        <br><br>
                    </div>
                </div>

                @if($statusText)
                    <div class="alert col-md-12 col-md-offset-2 {{ $statusType == 'success' ? 'alert-success' : ($statusType == 'error' ? 'alert-danger' : 'alert-info') }}" style="padding-top: 20px;">
                        {{ $statusText }}
                    </div>
                @endif
        @endif {{-- end of if ... activeFile->import_type --}}

    </div><!-- /div v-show -->

<script>
$(function () {
    // initialize iCheck for use with livewire
    $('.minimal.livewire-icheck').iCheck({
        checkboxClass: 'icheckbox_minimal-blue',
    })

    // we have to hook up to the `<tr id='importer-file'>` at the root of this display,
    // because the #import button isn't visible until you click an import_type
    $('#importer-file').on('click', '#import', function () {
        console.warn("You clicked it!!!!")
        if(!@this.activeFile.import_type) {
            @this.statusType='error';
            @this.statusText= "An import type is required... "; //TODO: translate?
            return;
        }
        @this.statusType ='pending';
        @this.statusText = "{{ trans('admin/hardware/form.processing_spinner') }}";
        @this.generate_field_map().then(function (mappings_raw) {
            var mappings = JSON.parse(mappings_raw)
            // console.warn("Here is the mappings:")
            // console.dir(mappings)
            $.post({
                url: "{{ route('api.imports.importFile', $activeFile->id) }}",
                contentType: 'application/json',
                data: JSON.stringify({
                    'import-update': !!@this.update,
                    'send-welcome': !!@this.send_welcome,
                    'import-type': @this.activeFile.import_type,
                    'run-backup': !!@this.run_backup,
                    'column-mappings': mappings
                }),
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
    });})

</script>