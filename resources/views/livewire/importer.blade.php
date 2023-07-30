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
            <button type="button" class="close" wire:click="$set('message','')">&times;</button>
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
                        <strong><i class="fa fa-warning info" aria-hidden="true"></i> {{ trans('general.warning', ['warning'=> trans('general.errors_importing')]) }}</strong>
                    </div>

                    <div class="errors-table">
                        <table class="table table-striped table-bordered" id="errors-table">
                            <thead>
                            <th>{{ trans('general.item') }}</th>
                            <th>{{ trans('general.error') }}</th>
                            </thead>
                            <tbody>
                            @php \Log::debug("import errors are: ".print_r($import_errors,true)); @endphp
                            @foreach($import_errors AS $key => $actual_import_errors)
                                @php \Log::debug("Key is: $key"); @endphp
                                @foreach($actual_import_errors AS $table => $error_bag)
                                    @php \Log::debug("Table is: $table"); @endphp
                                    @foreach($error_bag as $field => $error_list)
                                        @php \Log::debug("Field is: $field"); @endphp
                                        <tr>
                                            <td>{{ $activeFile->file_path ?? "Unknown File" }}</td>
                                            <td>
                                                <b>{{ $field }}:</b>
                                                <span>{{ implode(", ",$error_list) }}</span>
                                                <br />
                                            </td>
                                        </tr>
                                    @endforeach
                                @endforeach
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

                                    		<tr style="{{ ($activeFile && ($currentFile->id == $activeFile->id)) ? 'font-weight: bold' : '' }}" class="{{ ($activeFile && ($currentFile->id == $activeFile->id)) ? 'warning' : '' }}">
                                    			<td class="col-md-6">{{ $currentFile->file_path }}</td>
                                    			<td class="col-md-3">{{ Helper::getFormattedDateObject($currentFile->created_at, 'datetime', false) }}</td>
                                    			<td class="col-md-1">{{ Helper::formatFilesizeUnits($currentFile->filesize) }}</td>
                                                <td class="col-md-1 text-right" style="white-space: nowrap;">
                                                    <button class="btn btn-sm btn-info" wire:click="selectFile({{ $currentFile->id }})">
                                                        <i class="fas fa-retweet fa-fw" aria-hidden="true"></i>
                                                        <span class="sr-only">{{ trans('general.import') }}</span>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger" wire:click="destroy({{ $currentFile->id }})">
                                                        <i class="fas fa-trash icon-white" aria-hidden="true"></i><span class="sr-only"></span></button>
                                    			</td>
                                    		</tr>

                                            @if( $currentFile && $activeFile && ($currentFile->id == $activeFile->id))
                                                <tr class="warning">
                                                    <td colspan="4">

                                                        <div class="form-group">

                                                                <label for="activeFile.import_type" class="col-md-3 col-xs-12">
                                                                    {{ trans('general.import_type') }}
                                                                </label>

                                                                <div class="col-md-9 col-xs-12">
                                                                    {{ Form::select('activeFile.import_type', $importTypes, $activeFile->import_type, [
                                                                        'id' => 'import_type',
                                                                        'class' => 'livewire-select2',
                                                                        'style' => 'min-width: 350px',
                                                                        'data-placeholder' => trans('general.select_var', ['thing' => trans('general.import_type')]),
                                                                        'placeholder' => '', //needed so that the form-helper will put an empty option first
                                                                        'data-minimum-results-for-search' => '-1', // Remove this if the list gets long enough that we need to search
                                                                        'data-livewire-component' => $_instance->id
                                                                    ]) }}
                                                                    @if ($activeFile->import_type === 'asset' && $snipeSettings->auto_increment_assets == 0)
                                                                        <p class="help-block">
                                                                            {{ trans('general.auto_incrementing_asset_tags_disabled_so_tags_required') }}
                                                                        </p>
                                                                    @endif
                                                                </div>
                                                            </div>

                                                            <div class="form-group col-md-9 col-md-offset-3">
                                                                <label class="form-control">
                                                                    <input type="checkbox" name="update" data-livewire-component="{{ $_instance->id }}" wire:model="update">
                                                                    {{ trans('general.update_existing_values') }}
                                                                </label>
                                                                @if ($activeFile->import_type === 'asset' && $snipeSettings->auto_increment_assets == 1 && $update)
                                                                    <p class="help-block">
                                                                        {{ trans('general.auto_incrementing_asset_tags_enabled_so_now_assets_will_be_created') }}
                                                                    </p>
                                                                @endif

                                                                <label class="form-control">
                                                                    <input type="checkbox" name="send_welcome" data-livewire-component="{{ $_instance->id }}" wire:model="send_welcome">
                                                                    {{ trans('general.send_welcome_email_to_users') }}
                                                                </label>

                                                                <label class="form-control">
                                                                    <input type="checkbox" name="run_backup" data-livewire-component="{{ $_instance->id }}" wire:model="run_backup">
                                                                    {{ trans('general.back_before_importing') }}
                                                                </label>

                                                            </div>


                                                            @if($statusText)
                                                                <div class="alert col-md-8 col-md-offset-3{{ $statusType == 'success' ? ' alert-success' : ($statusType == 'error' ? ' alert-danger' : ' alert-info') }}" style="padding-top: 20px;">
                                                                    {!! $statusText !!}
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
                                                                        <strong>{{ trans('general.csv_header_field') }}</strong>
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <strong>{{ trans('general.import_field') }}</strong>
                                                                    </div>
                                                                    <div class="col-md-5">
                                                                        <strong>{{ trans('general.sample_value') }}</strong>
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
                                                                                        'placeholder' => trans('general.importer.do_not_import'),
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
                                                                    {{ trans('general.no_headers') }}
                                                                @endif

                                                                <div class="form-group col-md-12">
                                                                    <div class="col-md-3 text-left">
                                                                        <a href="#" wire:click="$set('activeFile',null)">{{ trans('general.cancel') }}</a>
                                                                    </div>
                                                                    <div class="col-md-9">
                                                                        <button type="submit" class="btn btn-primary col-md-5" id="import">Import</button>
                                                                        <br><br>
                                                                    </div>
                                                                </div>

                                                                @if($statusText)
                                                                    <div class="alert col-md-8 col-md-offset-3{{ $statusType == 'success' ? ' alert-success' : ($statusType == 'error' ? ' alert-danger' : ' alert-info') }}" style="padding-top: 20px;">
                                                                        {!! $statusText !!}
                                                                    </div>
                                                                @endif
                                                            @else
                                                                <div class="form-group col-md-10">
                                                                    <div class="col-md-3 text-left">
                                                                        <a href="#" wire:click="$set('activeFile',null)">{{ trans('general.cancel') }}</a>
                                                                    </div>
                                                                </div>
                                                            @endif {{-- end of if ... activeFile->import_type --}}

                                                        </div><!-- /div v-show -->                                                    </td>
                                                </tr>
                                            @endif
                                            </tr>
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
                @this.progress_message = @this.progress+'% Complete'; // TODO - make this use general.percent_complete as a translation, passing :percent as a variable
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

        // For the importFile part:
        $(function () {


            // we have to hook up to the `<tr id='importer-file'>` at the root of this display,
            // because the #import button isn't visible until you click an import_type
            $('#upload-table').on('click', '#import', function () {
                if(!@this.activeFile.import_type) {
                    @this.statusType='error';
                    @this.statusText= "An import type is required... "; //TODO: translate?
                    return;
                }
                @this.statusType ='pending';
                @this.statusText = '<i class="fa fa-spinner fa-spin" aria-hidden="true"></i> {{ trans('admin/hardware/form.processing_spinner') }}';
                @this.generate_field_map().then(function (mappings_raw) {
                    var mappings = JSON.parse(mappings_raw)
                    // console.warn("Here is the mappings:")
                    // console.dir(mappings)
                    // console.warn("Uh, active file id is, I guess: "+@this.activeFile.id)
                    var this_file = @this.file_id; // okay, I actually don't know what I'm doing here.
                    $.post({
                        {{-- I want to do something like: route('api.imports.importFile', $activeFile->id) }} --}}
                        url: "api/v1/imports/process/"+this_file, // maybe? Good a guess as any..FIXME. HARDCODED DUMB FILE
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
                        @this.statusText = "{{ trans('general.success_redirecting') }}";
                        // console.dir(body)
                        window.location.href = body.messages.redirect_url;
                    }).fail( function (jqXHR, textStatus, error) {
                        // Failure
                        var body = jqXHR.responseJSON
                        if((body) && (body.status) && body.status == 'import-errors') {
                            @this.emit('importError', body.messages);
                            @this.import_errors = body.messages

                            @this.statusType='error';
                            @this.statusText = "Error";

                        //  If Slack/notifications hits API thresholds, we *do* 500, but we never
                        //  actually surface that info.
                        //
                        // A 500 on notifications doesn't mean your import failed, so this is a confusing state.
                        //
                        //  Ideally we'd have a message like "Your import worked, but not all
                        // notifications could be sent".
                        } else {
                            console.warn("Not import-errors, just regular errors - maybe API limits")
                            @this.message_type="warning"
                            if ((body) && (error in body)) {
                                @this.message = body.error ? body.error:"Unknown error - might just be throttling by notifications."
                            } else {
                                @this.message = "{{ trans('general.importer_generic_error') }}"
                            }

                        }
                        @this.activeFile = null; //@this.set('hideDetails')
                    });
                })
                return false;
            });})

    </script>
@endpush
