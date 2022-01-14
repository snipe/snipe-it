<div id="not-app">
    {{-- <importer inline-template v-cloak> --}} {{-- like, this, here, that's a literal Vue directive --}}
        <div class="row">
        {{-- <alert v-show="alert.visible" :alert-type="alert.type" v-on:hide="alert.visible = false">@{{ alert.message }}</alert> --}}
<template>
    <div class="box" v-if="errors">
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
          <tr v-for="(error, item) in errors">
            <td>{{-- item --}}</td>
            <td v-for="(value, field) in error">
                <b>{{-- field --}}:</b>
                <span v-for="errorString in value">{{-- errorString[0] --}}</span>
              <br />
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</div>
</template>

{{-- alert --}}
<template>
        <div class="col-md-12" :class="alertType">
            <div class="alert" :class="alertClassName">
                <button type="button" class="close" @click="hideEvent">&times;</button>
                <i class="fas fa-check faa-pulse animated" aria-hidden="true" v-show="alertType == 'success'"></i>
                <strong>{{-- title --}} </strong>
                <slot></slot>
            </div>
        </div>
</template>

<script>
    fixme = {
        /*
         * The component's data.
         */
        props: ['alertType', 'title'],

        computed: {
            alertClassName() {
                return 'alert-' + this.alertType;
            }
        },

        methods: {
            hideEvent() {
                this.$emit('hide');
            }
        }
    }

</script>
            {{-- errors thing that's built-in maybe? --}}
            {{-- <errors :errors="importErrors"></errors> --}}

            <div class="col-md-9">
                <div class="box">
                    <div class="box-body">
                        <div class="row">

                            <div class="col-md-12">

                                <div class="col-md-9" style="padding-bottom:20px; display:none" id='progress-container'>
                                    <div class="progress progress-striped-active" style="margin-top: 8px"> {{-- so someof these values are in importer.vue! --}}
                                        <div id='progress-bar' class="progress-bar" class="progress-bar-warning" role="progressbar" style="width: 0%">
                                            <span id='progress-text'></span>
                                        </div>
                                    </div>
                                </div>

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
                                <button wire:click="test">Test!</button><br />
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
                                            <?php 
                                            \Log::error(print_r($currentFile,true))
                                            ?>
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
                                                    <button class="btn btn-sm btn-danger" @click="deleteFile(currentFile)">
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
            console.log("OKAY - we are gonna dump us out some files here!")
             console.dir(Livewire.first().files)
        })

        $('#fileupload').fileupload({
            dataType: 'json',
            done: function(e, data) {
                $('#progress-bar').attr("class", "progress-bar-success");
                $('#progress-text').text("Success!"); // same here? TODO - internationalize!
                $('#progress-bar').attr('style', 'width: 100%'); // weird, wasn't needed before....
                console.log("Dumping livewire files!!!!!!!!!")
                console.dir(Livewire.first().files)
                console.log("And now dumping data.result.files!!!!!")
                console.dir(data.result.files)
                //Livewire.first().files = data.result.files.concat(Livewire.first().files); // FIXME - how to get in and out of the Livewire.first().something.... (this doesn't work either)
                // Livewire.first().files = Livewire.first().files.concat(data.result.files) //I don't quite see why this should be like this, but, well, whatever.
                //fuckit, let's just force a refresh?
                Livewire.first().forcerefresh = Livewire.first().forcerefresh+1 // this is a horrible hack; please forgive me :(
                console.log(data.result.header_row);
                console.dir()
            },
            add: function(e, data) {
                data.headers = {
                    "X-Requested-With": 'XMLHttpRequest',
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr('content')
                };
                data.process().done( function () {data.submit();});
                $('#progress-container').show();
            },
            progress: function(e, data) {
                var progress = parseInt((data.loaded / data.total * 100, 10));
                $('#progress-bar').attr('style', 'width: '+progress+'%');
                $('#progress-text').text(progress+'% Complete');
            },
            fail: function(e, data) {
                $('#progress-bar').attr("class", "progress-bar-danger");
                // Display any errors returned from the $.ajax()
                console.dir(data.jqXHR.responseJSON.messages) // FIXME don't dupm to console
                $('#progress-bar').attr('style', 'width: 100%');
                $('#progress-text').text(data.jqXHR.responseJSON.messages);
            }
        })
    </script>
@endpush