@extends('layouts/default')

{{-- Page title --}}
@section('title')
{{ trans('general.import') }}
@parent
@stop

{{-- Page content --}}
@section('content')
    {{-- Hide importer until vue has rendered it, if we continue using vue for other things we should move this higher in the style --}}
    <style>
        [v-cloak] {
            display:none;
        }

        /* Rules for the div table */
        .tbl_head {
            font-weight: bold;
        }
        .div_tbl {
            display: table;
        }
        .div_tbl_row {
            display: table-row;
        }
        .div_tbl_cell {
            display: table-cell;
            padding: 2px
        }
    </style>

<div id="app">
    <importer inline-template v-cloak>
        <div class="row">
        <alert v-show="alert.visible" :alert-type="alert.type" v-on:hide="alert.visible = false">@{{ alert.message }}</alert>
            <errors :errors="importErrors"></errors>

            <div class="col-md-9">
                <div class="box">
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-3 pull-right">

                                <!-- The fileinput-button span is used to style the file input field as button -->
                                @if (!config('app.lock_passwords'))
                                <span class="btn btn-primary fileinput-button">
                                    <span>Select Import File...</span>
                                    <!-- The file input field used as target for the file upload widget -->
                                    <label for="files[]"><span class="sr-only">Select file</span></label>
                                    <input id="fileupload" type="file" name="files[]" data-url="{{ route('api.imports.index') }}" accept="text/csv" aria-label="files[]">
                                </span>
                                 @endif

                            </div>
                            <div class="col-md-9" v-show="progress.visible" style="padding-bottom:20px">
                                <div class="col-md-11">
                                    <div class="progress progress-striped-active" style="margin-top: 8px">
                                        <div class="progress-bar" :class="progress.currentClass" role="progressbar" :style="progressWidth">
                                            <span>@{{ progress.statusText }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12" style="padding-top: 30px;">
                                <div class="table table-striped" id="upload-table">
                                    <div class="div_tbl_row col-md-12">
                                        <div class="tbl_head col-md-5">File</div>
                                        <div class="tbl_head col-md-3">Created</div>
                                        <div class="tbl_head col-md-2">Size</div>
                                        <div class="tbl_head col-md-2"></div>
                                    </div>

                                    <template v-for="currentFile in files">
                                    		<div class="div_tbl_row col-md-12">
                                    			<div class="div_tbl_cell col-md-5">@{{ currentFile.file_path }}</div>
                                    			<div class="div_tbl_cell col-md-3">@{{ currentFile.created_at }} </div>
                                    			<div class="div_tbl_cell col-md-2">@{{ currentFile.filesize }}</div>

                                                <div class="div_tbl_cell col-md-2">
                                    			    <button class="btn btn-sm btn-info" @click="toggleEvent(currentFile.id)">Process</button>
                                                    <button class="btn btn-sm btn-danger" @click="deleteFile(currentFile)"><i class="fa fa-trash icon-white"></i></button>
                                    			</div>
                                    		</div>

                                            <import-file
                                                :key="currentFile.id"
                                                :file="currentFile"
                                                :custom-fields="customFields"
                                                @alert="updateAlert(alert)">
                                            </import-file>
                                    </template>
                                </div>
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
    </importer>
</div>
@stop

@section('moar_scripts')
<script nonce="{{ csrf_token() }}">
    new Vue({
        el: '#app'
    });
</script>
@endsection
