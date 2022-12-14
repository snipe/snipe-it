<div id="not-app">
    {{-- <importer inline-template v-cloak> --}} {{-- like, this, here, that's a literal Vue directive --}}
        <div class="row">
        {{-- <alert v-show="alert.visible" :alert-type="alert.type" v-on:hide="alert.visible = false">@{{ alert.message }}</alert> --}}

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

            {{-- errors thing that's built-in maybe? No. It's importer-error.vue --}}
@if($import_errors)
            <div class="box">
                <div class="box-body">
                    <div class="alert alert-warning">
                        <strong>Warning</strong> Some Errors occured while importing
                    </div>

                    <div class="errors-table">
                        <table class="table table-striped table-bordered" id="errors-table">
                            <thead>
                            <th>Item</th>
                            <th>Errors</th>
                            </thead>
                            <tbody>
                            @foreach($import_errors as $field => $error_list)
                            <tr>
                                <td>{{ $processDetails->file_path }}</td>
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
                                        <span>{{ trans('admin/importer/general.select_import_file') }}</span>
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
                                        <th class="col-md-6">{{ trans('admin/importer/table.file') }}</th>
                                        <th class="col-md-3">{{ trans('admin/importer/table.created') }}</th>
                                        <th class="col-md-1">{{ trans('admin/importer/table.size') }}</th>
                                        <th class="col-md-1 text-right"><span class="sr-only">{{ trans('admin/importer/table.process') }}</span></th>
                                        <th class="col-md-1 text-right"><span class="sr-only">{{ trans('admin/importer/table.delete') }}</span></th>
                                    </tr>

                                    {{-- <template v-for="currentFile in files"> --}}
                                    @foreach($files as $currentFile)
                                    		<tr>
                                    			<td class="col-md-6">{{ $currentFile->file_path }}</td>
                                    			<td class="col-md-3">{{ $currentFile->created_at }} </td>
                                    			<td class="col-md-1">{{ $currentFile->filesize }}</td>
                                                <td class="col-md-1 text-right">
                                                    <button class="btn btn-sm btn-info" wire:click="toggleEvent({{ $currentFile->id }})">
                                                        {{ trans('admin/importer/button.process') }}
                                                    </button>
                                                </td>
                                                <td class="col-md-1 text-right">
                                                    <button class="btn btn-sm btn-danger" wire:click="destroy({{ $currentFile->id }})">
                                                        <i class="fas fa-trash icon-white" aria-hidden="true"></i><span class="sr-only"></span></button>
                                    			</td>
                                    		</tr>
                                                @if( $currentFile && $processDetails && ($currentFile->id == $processDetails->id))
                                                    @livewire('importer-file', ['activeFile' => $currentFile])
                                                {{-- <import-file
                                                    :key="currentFile.id"
                                                    :file="currentFile"
                                                    :custom-fields="customFields"
                                                    @alert="updateAlert(alert)">
                                                </import-file> --}}
                                                @endif
                                    @endforeach
                                    {{-- </template> --}}
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
    {{-- </importer> --}}
</div>
@push('js')
    <script>
        document.addEventListener('livewire:load', function () {
            // console.log("OKAY - we are gonna dump us out some files here!")
            // console.dir(@this.files)
            // console.log("after livewire load, we're going to try the this thing")
            // console.dir(@this)
        })

        {{-- FIXME: Maybe change this to the file upload thing that's baked-in to Livewire? --}}
        $('#fileupload').fileupload({
            dataType: 'json',
            done: function(e, data) {
                //$('#progress-bar').attr("class", "progress-bar-success");
                @this.progress_bar_class = 'progress-bar-success';
                //$('#progress-text').text("Success!"); // same here? TODO - internationalize!
                @this.progress_message = 'Success!'; // FIXME - we're already round-tripping to the server here - I'd love it if we could get internationalized text here
                //$('#progress-bar').attr('style', 'width: 100%'); // weird, wasn't needed before....
                @this.progress = 100;
                console.log("Dumping livewire files!!!!!!!!!")
                console.dir(@this.files)
                console.log("And now dumping data.result.files!!!!!")
                console.dir(data.result.files)
                //@this.files = data.result.files.concat(@this.files); // FIXME - how to get in and out of the @this.something.... (this doesn't work either)
                // @this.files = @this.files.concat(data.result.files) //I don't quite see why this should be like this, but, well, whatever.
                //fuckit, let's just force a refresh?
                // NB - even if that *did* work, I suspect it would re-flash the progressbar, which we would not like.
                // perhaps a better angle would be to  have a 'progress' PHP attribute, and update that dynamically, and let Livewire re-render it as appropriate?
                @this.forcerefresh = @this.forcerefresh+1 // this is a horrible hack; please forgive me :(
                console.log(data.result.header_row);
                console.dir()
            },
            add: function(e, data) {
                data.headers = {
                    "X-Requested-With": 'XMLHttpRequest',
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr('content')
                };
                data.process().done( function () {data.submit();});
                // $('#progress-container').show();
                @this.progress = 0;
            },
            progress: function(e, data) {
                @this.progress = parseInt((data.loaded / data.total * 100, 10));
                //$('#progress-bar').attr('style', 'width: '+progress+'%');
                @this.progress_message = @this.progress+'% Complete'; // FIXME - this should come from server (so it can be internationalized)
                //$('#progress-text').text(progress+'% Complete');
            },
            fail: function(e, data) {
                @this.progress_bar_class = "progress-bar-danger";
                // Display any errors returned from the $.ajax()
                console.dir(data.jqXHR.responseJSON.messages) // FIXME don't dupm to console
                //$('#progress-bar').attr('style', 'width: 100%');
                @this.progress = 100;
                //$('#progress-text').text(data.jqXHR.responseJSON.messages);
                console.dir(data.jqXHR.responseJSON.messages);
                var error_message = ''
                for(var i in data.jqXHR.responseJSON.messages) {
                    error_message += i+": "+data.jqXHR.responseJSON.messages[i].join(", ")
                }
                @this.progress_message = error_message;
            }
        })
    </script>
@endpush