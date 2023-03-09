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

                                    		<tr style="{{ ($processDetails && ($currentFile->id == $processDetails->id)) ? 'font-weight: bold' : '' }}" class="{{ ($processDetails && ($currentFile->id == $processDetails->id)) ? 'warning' : '' }}">
                                    			<td class="col-md-6">{{ $currentFile->file_path }}</td>
                                    			<td class="col-md-3">{{ Helper::getFormattedDateObject($currentFile->created_at, 'datetime', false) }}</td>
                                    			<td class="col-md-1">{{ Helper::formatFilesizeUnits($currentFile->filesize) }}</td>
                                                <td class="col-md-1 text-right">
                                                    <button class="btn btn-sm btn-info" wire:click="toggleEvent({{ $currentFile->id }})">
                                                        <i class="fas fa-retweet fa-fw" aria-hidden="true"></i>
                                                        <span class="sr-only">{{ trans('general.import') }}</span>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger" wire:click="destroy({{ $currentFile->id }})">
                                                        <i class="fas fa-trash icon-white" aria-hidden="true"></i><span class="sr-only"></span></button>
                                    			</td>
                                    		</tr>

                                            @if( $currentFile && $processDetails && ($currentFile->id == $processDetails->id))
                                                <tr class="warning">
                                                    <td colspan="4">
                                                        @livewire('importer-file', ['activeFile' => $currentFile])
                                                    </td>
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