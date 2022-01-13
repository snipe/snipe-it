{{-- <template> --}}
  <tr v-show="processDetail">
    <td colspan="5">
    <div class="col-md-12">

            <div class="row">
                <div class="dynamic-form-row">
                    <div class="col-md-5 col-xs-12">
                        <label for="import-type">Import Type:</label>
                    </div>

                    <div class="col-md-7 col-xs-12">
                        {{ Form::select('importType', $importTypes, 0 /* FIXME whats' the old value? */, ['placeholder' => '', 'wire:model' => 'importType', 'wire:change' => 'changeTypes']) }}
                        {{-- <select2 :options="options.importTypes" v-model="options.importType" required> --}}
                            {{-- <option disabled value="0"></option> --}}
                        {{-- </select2> --}}
                    </div>

                </div><!-- /dynamic-form-row -->
                <div class="dynamic-form-row">
                    <div class="col-md-5 col-xs-12">
                        <label for="import-update">Update Existing Values?:</label>
                    </div>
                    <div class="col-md-7 col-xs-12">
                        <input type="checkbox" class="iCheck minimal" name="import-update" v-model="options.update">
                    </div>
                </div><!-- /dynamic-form-row -->

                <div class="dynamic-form-row">
                    <div class="col-md-5 col-xs-12">
                        <label for="send-welcome">Send Welcome Email for new Users?</label>
                    </div>
                    <div class="col-md-7 col-xs-12">
                        <input type="checkbox" class="minimal" name="send-welcome" v-model="options.send_welcome">
                    </div>
                </div><!-- /dynamic-form-row -->

                <div class="dynamic-form-row">
                    <div class="col-md-5 col-xs-12">
                        <label for="run-backup">Backup before importing?</label>
                    </div>
                    <div class="col-md-7 col-xs-12">
                        <input type="checkbox" class="minimal" name="run-backup" v-model="options.run_backup">
                    </div>
                </div><!-- /dynamic-form-row -->

                <div class="alert col-md-8 col-md-offset-2" style="text-align:left"
                     :class="alertClass"
                     v-if="statusText">
                    {{-- this.statusText --}}
                </div><!-- /alert -->
        </div> <!-- /div row -->

        <div class="row">
            <div class="col-md-12" style="padding-top: 30px;">
                <div class="col-md-4 text-right"><h4>Header Field</h4></div>
                <div class="col-md-4"><h4>Import Field</h4></div>
                <div class="col-md-4"><h4>Sample Value</h4></div>
            </div>
        </div><!-- /div row -->

        {{-- <template v-for="(header, index) in file.header_row"> --}}
        @if($activeFile->header_row)
            @foreach($activeFile->header_row AS $index => $header)
                <div class="row">
                    <div class="col-md-12">
                        <div class="col-md-4 text-right">
                            <label :for="header" class="control-label">{{ $header }}</label>
                        </div>
                        <div class="col-md-4 form-group">
                            <div required>
                                {{-- <select2 :options="columns" v-model="columnMappings[header]">
                                    <option value="0">Do Not Import</option>
                                </select2> --}}
                                {{ Form::select('something', $columnOptions[$importType], null /* FIXME whats' the old value? */,['placeholder' => 'Do Not Import']) }}
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
        {{-- </template> --}}

        <div class="row">
            <div class="col-md-6 col-md-offset-2 text-right" style="padding-top: 20px;">
                <button type="button" class="btn btn-sm btn-default" @click="processDetail = false">Cancel</button>
                <button type="submit" class="btn btn-sm btn-primary" @click="postSave">Import</button>
                <br><br>
            </div>
        </div><!-- /div row -->
        <div class="row">
            <div class="alert col-md-8 col-md-offset-2" style="padding-top: 20px;"
                 :class="alertClass"
                 v-if="statusText">
                {{-- this.statusText --}}
            </div>
        </div><!-- /div row -->

    </div><!-- /div v-show -->

    </td>

    <script>
        unused_var_thing = {
            data() {
                return {
                    activeFile: this.file,
                    processDetail: false,
                    statusText: null,
                    statusType: null,
                    options: {
                        importType: this.file.import_type,
                        update: false,
                        statusText: null,
                    },

                    activeColumn: null,
                }
            },
            created() {
                this.populateSelect2ActiveItems();
            },
            computed: {
                alertClass() {
                    if(this.statusType=='success') {
                        return 'alert-success';
                    }
                    if(this.statusType=='error') {
                        return 'alert-danger';
                    }
                    return 'alert-info';
                },
            },
            watch: {
                columns() {
                    this.populateSelect2ActiveItems();
                }
            },
            methods: {
                postSave() {
                    console.log('saving');
                    console.log(this.options.importType);
                    if(!this.options.importType) {
                        this.statusType='error';
                        this.statusText= "An import type is required... ";
                        return;
                    }
                    this.statusType='pending';
                    this.statusText = "Processing...";
                    this.$http.post(route('api.imports.importFile', this.file.id), {
                        'import-update': this.options.update,
                        'send-welcome': this.options.send_welcome,
                        'import-type': this.options.importType,
                        'run-backup': this.options.run_backup,
                        'column-mappings': this.columnMappings
                    }).then( ({body}) => {
                        // Success
                        this.statusType="success";
                        this.statusText = "Success... Redirecting.";
                        window.location.href = body.messages.redirect_url;
                    }, ({body}) => {
                        // Failure
                        if(body.status == 'import-errors') {
                            window.eventHub.$emit('importErrors', body.messages);
                            this.statusType='error';
                            this.statusText = "Error";
                        } else {
                            this.$emit('alert', {
                                message: body.messages,
                                type: "danger",
                                visible: true,
                            })
                        }
                        this.displayImportModal=false;
                    });
                },
                populateSelect2ActiveItems() {
                    if(this.file.field_map == null) {
                        // Begin by populating the active selection in dropdowns with blank values.
                        for (var i=0; i < this.file.header_row.length; i++) {
                            this.$set(this.columnMappings, this.file.header_row[i], null);
                        }
                        // Then, for any values that have a likely match, we make that active.
                        for(var j=0; j < this.columns.length; j++) {
                            let column = this.columns[j];
                            let lower = this.file.header_row.map((value) => value.toLowerCase());
                            let index = lower.indexOf(column.text.toLowerCase())
                            if(index != -1) {
                                this.$set(this.columnMappings, this.file.header_row[index], column.id)
                            }
                        }
                    }
                },
                updateModel(header, value) {
                    this.columnMappings[header] = value;
                }
            },
        }
    </script>

  </tr>
{{-- </template> --}}
