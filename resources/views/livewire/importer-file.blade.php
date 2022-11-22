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
                        <span wire:ignore>
                            {{ Form::select('import_type', $importTypes, $activeFile->import_type, ['id' => 'import_type', 'class' => 'livewire-select2', 'placeholder' => '', 'data-livewire-model' => 'activeFile.import_type']) }}
                        </span>
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
                        <input type="checkbox" class="iCheck minimal" name="import-update" wire:model="update">
                    </div>
                </div><!-- /dynamic-form-row -->

                <div class="dynamic-form-row">
                    <div class="col-md-5 col-xs-12">
                        <label for="send_welcome">Send Welcome Email for new Users?</label>
                    </div>
                    <div class="col-md-7 col-xs-12">
                        <input type="checkbox" class="minimal" name="send_welcome" wire:model="send_welcome">
                    </div>
                </div><!-- /dynamic-form-row -->

                <div class="dynamic-form-row">
                    <div class="col-md-5 col-xs-12">
                        <label for="run_backup">Backup before importing?</label>
                    </div>
                    <div class="col-md-7 col-xs-12">
                        <input type="checkbox" class="minimal" name="run_backup" wire:model="run_backup">
                    </div>
                </div><!-- /dynamic-form-row -->

                @if($statusText)
                <div class="alert col-md-8 col-md-offset-2 {{ $statusType == 'success' ? 'alert-success' : ($statusType == 'error' ? 'alert-danger' : 'alert-info') }}" style="text-align:left"
                     >
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

        {{-- <template v-for="(header, index) in file.header_row"> --}}
        @if($activeFile->header_row)
            @foreach($activeFile->header_row AS $index => $header)
                <div class="row" wire:key="fake_key-{{ base64_encode($header) }}-{{ $increment }}">
                    <div class="col-md-12">
                        <div class="col-md-4 text-right">
                            <!-- FIXME - no :for -->
                            <label :for="header" class="control-label">{{ $header }}</label>
                        </div>
                        <div class="col-md-4 form-group">
                            <div required data-force-refresh="{{ $increment }}">
                                {{-- <select2 :options="columns" v-model="columnMappings[header]">
                                    <option value="0">Do Not Import</option>
                                </select2> --}}
                                <span wire:ignore>
                                    {{ Form::select('mapping[]', $columnOptions[$activeFile->import_type], @$activeFile->field_map[$header], [/*'class' => 'livewire-select2 mappings', */'data-livewire-mapping' => $header, 'placeholder' => 'Do Not Import']) }}
                                </span>
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
                <button type="button" class="btn btn-sm btn-default" wire:click="$emit('hideDetails')">Cancel</button>
                <button type="submit" class="btn btn-sm btn-primary" wire:click="postSave">Import</button>
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

    <script>
        var unused_var_thing = {
            created() {
                this.populateSelect2ActiveItems();
            },
            watch: {
                columns() {
                    this.populateSelect2ActiveItems();
                }
            },
            methods: {
                postSave() {
                    /* started cutting here ... */
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
<script>
$(function () {
    console.warn("Setting iCheck callbacks!")
    $('.iCheck').on('ifToggled', function (event) {
        console.warn("iCheck checked!")
        console.dir(event.target)
        @this.set(event.target.name, event.target.checked)
    })
})

    $('.livewire-select2').select2();
$('#import_type').on('select2:select', function (event) {
    console.log("import_type select2 selected!!!!!!!!!!!")
    //console.dir(event.params.data)
    //console.dir(event)
    var livewire_model = $(event.target).data('livewire-model')
    console.log("Okay, so I think it's: "+livewire_model)
    if ( livewire_model ) {
        @this[livewire_model] = event.params.data.id
    }
    @this.emit('refreshComponent')
    @this.increment = @this.increment + 1 //forces refresh (no, apparently it doesn't)
    console.warn("new increment is: "+@this.increment)
    //@this.mappings = 'dingus';
})
$('.mappings').on('select2:select', function (event) {
    console.warn("Mapping-type select2 selected")
    var mapping = $(event.target).data('livewire-mapping')
    @this.field_map[mapping] = event.params.data.id
    @this.emit('refreshComponent')
})
console.warn("Doing the livewire:load callback...")
/* on livewire load, set a callback that, right before re-render, re-runs livewire2? */
$(function () {
    document.addEventListener('component.initialized', function () {
        console.warn("Livewire has loaded; adding element.updated hook!")
        return false; // FIXME
        Livewire.hook('element.updated', function (element, component) {
            console.warn("Re-select-2'ing all select2's!")
            $('.livewire-select2').select2('destroy').select2(); // TODO - this repeats in the script block above.

        })
    })
})
window.setTimeout(  function () {
    console.warn("Livewire has loaded; adding element.updated hook! (via DELAY!)")
    return false; // FIXME TOO
    Livewire.hook('element.updated', function (element, component) {
        console.warn("Re-select-2'ing all select2's!")
        $('.livewire-select2').select2('destroy').select2(); // TODO - this repeats in the script block above.

    })
},3000) // FIXME - this is stupid.
</script>