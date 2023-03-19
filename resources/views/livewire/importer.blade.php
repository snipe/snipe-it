@section('title')
    {{ trans('general.import') }}
    @parent
@stop
<div>
    {{-- Livewire requires a 'master' <div>, above --}}
        <div class="row">

{{-- alert --}}
@if($message != '')
    <div class="col-md-12" class="{{ $message_type }}">
        <div class="alert alert-{{ $this->message_type }} ">
            <button type="button" class="close" wire:click="hideMessages">&times;</button>
            @if($message_type == 'success')
                <i class="fas fa-check faa-pulse animated" aria-hidden="true"></i>
            @endif
            <strong>{{-- title --}} </strong>
            {{ $message }}
        </div>
    </div>
@endif

@if($import_errors)
            <div class="box">
                <div class="box-body">
                    <div class="alert alert-warning">
                        <strong>Warning</strong> Some Errors occurred while importing {{-- TODO: hardcoded string --}}
                    </div>

                    <div class="errors-table">
                        <table class="table table-striped table-bordered" id="errors-table">
                            <thead>
                            <th>{{ trans('general.item') }}</th>
                            <th>{{ trans('general.error') }}</th>
                            </thead>
                            <tbody>
                            @foreach($import_errors as $field => $error_list)
                            <tr>
                                <td>{{ $processDetails->file_path ?? "Unknown File" }}</td>
                                <td>
                                    <b>{{ $field }}:</b>
                                    <span>{{ implode(", ",$error_list) }}</span>
                                    <br />
                                </td>
                            </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
@endif

            <div class="col-md-9">
                <div class="box">
                    <div class="box-body">
                        <div class="row">

                            <div class="col-md-12">
                                @if($progress != -1)
                                    <div class="col-md-9" style="padding-bottom:20px" id='progress-container'>
                                        <div class="progress progress-striped-active" style="margin-top: 8px"> {{-- so someof these values are in importer.vue! --}}
                                            <div id='progress-bar' class="progress-bar {{ $progress_bar_class }}" role="progressbar" style="width: {{ $progress }}%">
                                                <span id='progress-text'>{{ $progress_message }}</span>
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                <div class="col-md-3 text-right pull-right">

                                    <!-- The fileinput-button span is used to style the file input field as button -->
                                    @if (!config('app.lock_passwords'))
                                        <span class="btn btn-primary fileinput-button">
                                        <span>{{ trans('button.select_file') }}</span>
                                         <!-- The file input field used as target for the file upload widget -->
                                        <label for="files[]"><span class="sr-only">{{ trans('admin/importer/general.select_file') }}</span></label>
                                        <input id="fileupload" type="file" name="files[]" data-url="{{ route('api.imports.index') }}" accept="text/csv" aria-label="files[]">
                                        </span>
                                    @endif

                                </div>

                            </div>



                        </div>
                        <div class="row">
                            <div class="col-md-12 table-responsive" style="padding-top: 30px;">
                                <table data-pagination="true"
                                        data-id-table="upload-table"
                                        data-search="true"
                                        data-side-pagination="client"
                                        id="upload-table"
                                        class="col-md-12 table table-striped snipe-table">

                                    <tr>
                                        <th class="col-md-6">
                                            {{ trans('general.file_name') }}
                                        </th>
                                        <th class="col-md-3">
                                            {{ trans('general.created_at') }}
                                        </th>
                                        <th class="col-md-1">
                                            {{ trans('general.filesize') }}
                                        </th>
                                        <th class="col-md-1 text-right">
                                            <span class="sr-only">{{ trans('general.actions') }}</span>
                                        </th>
                                    </tr>

                                    @foreach($files as $currentFile)

                                    		<tr wire:key="current-file-selection-{{ $currentFile->id }}" style="{{ ($processDetails && ($currentFile->id == $processDetails->id)) ? 'font-weight: bold' : '' }}" class="{{ ($processDetails && ($currentFile->id == $processDetails->id)) ? 'warning' : '' }}">
                                    			<td class="col-md-6">{{ $currentFile->file_path }}</td>
                                    			<td class="col-md-3">{{ Helper::getFormattedDateObject($currentFile->created_at, 'datetime', false) }}</td>
                                    			<td class="col-md-1">{{ Helper::formatFilesizeUnits($currentFile->filesize) }}</td>
                                                <td class="col-md-1 text-right">
                                                    <button class="btn btn-sm btn-info" wire:click="$set('activeFile',{{ $currentFile->id }})">
                                                        <i class="fas fa-retweet fa-fw" aria-hidden="true"></i>
                                                        <span class="sr-only">{{ trans('general.import') }}</span>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger" wire:click="destroy({{ $currentFile->id }})">
                                                        <i class="fas fa-trash icon-white" aria-hidden="true"></i><span class="sr-only"></span></button>
                                    			</td>
                                    		</tr>
                                            <?php
                                                \Log::error("Current file is: ".$currentFile->id);
                                            ?>
                                            @if( $currentFile && $processDetails && ($currentFile->id == $processDetails->id))
                                                <tr class="warning">
                                                    <td colspan="4" >

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
                                                                        'data-livewire-component' => $_instance->id,
                                                                        'onchange' => "console.log('FAAAAAAAARTs');return true"
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
                                                        </div><!-- /div v-show -->

                                                    </td>
                                                </tr>
                                            @endif
                                    @endforeach
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <h2>{{ trans('general.importing') }}</h2>
                <p>{!!   trans('general.importing_help') !!}</p>
            </div>

        </div>
</div>
</div> {{-- DID I HAVE A MISSING CLOSING DIV HERE? PROBABLY!!!!  --}}
@push('js')
    <script>

        {{-- TODO: Maybe change this to the file upload thing that's baked-in to Livewire? --}}
        $('#fileupload').fileupload({
            dataType: 'json',
            done: function(e, data) {
                @this.progress_bar_class = 'progress-bar-success';
                @this.progress_message = '{{ trans('general.notification_success') }}'; // TODO - we're already round-tripping to the server here - I'd love it if we could get internationalized text here
                @this.progress = 100;
            },
            add: function(e, data) {
                data.headers = {
                    "X-Requested-With": 'XMLHttpRequest',
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr('content')
                };
                data.process().done( function () {data.submit();});
                @this.progress = 0;
            },
            progress: function(e, data) {
                @this.progress = parseInt((data.loaded / data.total * 100, 10));
                @this.progress_message = @this.progress+'% Complete'; // TODO - this should come from server (so it can be internationalized)
            },
            fail: function(e, data) {
                @this.progress_bar_class = "progress-bar-danger";
                @this.progress = 100;

                var error_message = ''
                for(var i in data.jqXHR.responseJSON.messages) {
                    error_message += i+": "+data.jqXHR.responseJSON.messages[i].join(", ")
                }
                @this.progress_message = error_message;
            }
        })
    </script>
@endpush