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

                            <div class="col-md-12">

                                <div class="col-md-9" v-show="progress.visible" style="padding-bottom:20px">
                                    <div class="progress progress-striped-active" style="margin-top: 8px">
                                        <div class="progress-bar" :class="progress.currentClass" role="progressbar" :style="progressWidth">
                                            <span>@{{ progress.statusText }}</span>
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

                                    <template v-for="currentFile in files">
                                    		<tr>
                                    			<td class="col-md-6">@{{ currentFile.file_path }}</td>
                                    			<td class="col-md-3">@{{ currentFile.created_at }} </td>
                                    			<td class="col-md-1">@{{ currentFile.filesize }}</td>
                                                <td class="col-md-1 text-right">
                                                    <button class="btn btn-sm btn-info" @click="toggleEvent(currentFile.id)">
                                                        {{ trans('admin/importer/button.process') }}
                                                    </button>
                                                </td>
                                                <td class="col-md-1 text-right">
                                                    <button class="btn btn-sm btn-danger" @click="deleteFile(currentFile)">
                                                        <i class="fas fa-trash icon-white" aria-hidden="true"></i><span class="sr-only"></span></button>
                                    			</td>
                                    		</tr>
                                                <import-file
                                                    :key="currentFile.id"
                                                    :file="currentFile"
                                                    :custom-fields="customFields"
                                                    @alert="updateAlert(alert)">
                                                </import-file>
                                    </template>
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
