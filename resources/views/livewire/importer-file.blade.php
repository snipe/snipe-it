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
                            <label for="field_map.{{ $index }}" class="control-label">{{ $header }}</label>
                        </div>
                        <div class="col-md-4 form-group">
                            <div required data-force-refresh="{{ $increment }}">
                                {{-- <select2 :options="columns" v-model="columnMappings[header]">
                                    <option value="0">Do Not Import</option>
                                </select2> --}}
{{--                                <span wire:ignore>--}}
                                    {{ Form::select('field_map.'.$index, $columnOptions[$activeFile->import_type], @$activeFile->field_map[$header],
                                        [
                                        'class' => 'mappings livewire-select2',
                                        'wire:model' => 'field_map.'.$index, // I think it just can't read this :/
                                        'data-livewire-mapping' => $header, // do we still need this?
                                        'data-livewire-model' => 'field_map.'.$index, // start of a 'universal' way to do this?
                                        'placeholder' => 'Do Not Import'
                                        ])

                                    }}
                                {{-- /* 'wire:model' => 'activeFile.field_map.'.$header, doesn't work */
                                        /*'class' => 'livewire-select2 mappings', */' --}}
{{--                                </span>--}}
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
                <button type="submit" class="btn btn-sm btn-primary" id="import">Import</button>
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
          function postSave() {
              // FIXME - this is just awful.
                console.warn("Saving import!");
                if (!@this['activeFile'].import_type) {
                    console.warn("didn't find an import type :(");
                    @this.set('statusType','error');
                    @this.set('statusText', "An import type is required... "); // TODO - translate me!
                    return false;
                }
                @this.set('statusType','pending');
                @this.set('statusText',"Processing...");
                // FIXME - switch this to a boring regular jquery post, or figure out how to use the baked-in copy of axios?

              var mappings = {};

              for(var i in @this.field_map) {
                  console.warn("I is: "+i)
                  console.warn("Field map for i is: "+@this.field_map[i])
                  console.dir(@this.activeFile)
                  console.dir(@this.activeFile.header_row)
                  console.warn("field value for is is: "+@this.activeFile.header_row[i])
                  mappings[@this.activeFile.header_row[i]] = @this.field_map[i]
              }

              axios.defaults.headers.common["X-CSRF-TOKEN"] = $('meta[name="csrf-token"]').attr('content')
                axios.post('{{ route('api.imports.importFile', $activeFile->id) }}', {
                    'import-update': !!@this.update,
                    'send-welcome': !!@this.send_welcome,
                    'import-type': @this.activeFile.import_type,
                    'run-backup': !!@this.run_backup,
                    'column-mappings': mappings // FIXME - terrible name
                }).then( (body) => {
                    console.warn("success!!!")
                    // Success
                    @this.set('statusType',"success");
                    @this.set('statusText', "Success... Redirecting.");
                    console.warn("Here is the body object: ")
                    console.dir(body);
                    // FIXME - can we 'flash' an update here?
                    window.location.href = body.data.messages.redirect_url;
                }, (body) => {
                    // Failure
                    console.warn("failure!!!!")
                    if(body.response.data.status == 'import-errors') {
                        //window.eventHub.$emit('importErrors', body.messages);
                        console.warn("import error")
                        console.dir(body)
                        @this.set('statusType','error');
                        @this.emit('importError', body.response.data.messages)
                        //@this.set('statusText', "Error: "+body.response.data.messages.join("<br>"));
                    } else {
                        console.warn("not import-errors, just regular errors")
                        console.dir(body)
                        @this.set('statusType','error');
                        @this.emit('importError',body.response.data.messages ? body.response.data.messages :  {'import-type': ['Unknown error']})
                        @this.set('statusText',body.response.data.messages ? body.response.data.messages : 'Unknown error');
                    }
                    // @this.emit('hideDetails');
                });
            }
          $(function () {
              $('#import').on('click',function () {
                  console.warn("okay, click handler firing!!!")
                  postSave()
              })
              console.warn("JS click handler loaded!")
          })
          window.setTimeout(function() {
              var what = @this.dinglefarts
              console.warn("What is this: ",what)
          },1000)
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
$('.mappings').on('change', function (event) { // or 'select2:select'
    @this.set($(event.target).data('livewire-model'), this.options[this.selectedIndex].value)
    return; // FIXME - or delete.







    // I mean, it's kinda crazy, but I think we don't even *have* to do this?
    // we can just get the state in the javascript that does the POST (Axios, but soon to be plain-ole' jquery)
    // so I think we can just not do this at all and do it there instead?
    console.warn("Mapping-type select2 selected")
    // console.dir(event);
    console.dir(this); // hrm?
    console.warn("Selected Index is: "+this.selectedIndex);
    var mapping = $(event.target).data('livewire-mapping')
    var field_map = @this.activeFile.field_map
    console.log("Field map before: ")
    console.dir(field_map)
    field_map[mapping] = this.options[this.selectedIndex].value
    console.log("field map after: ")
    console.dir(field_map)
    @this.set('activeFile.field_map',field_map)
    //@this.set('activeFile.field_map.'+mapping, this.options[this.selectedIndex].value) // doesn't work?
    // @this.field_map[mapping] = event.params.data.id // seems to be a select2-ism?
    @this.emit('refreshComponent')
})
//console.warn("Doing the livewire:load callback...")
/* on livewire load, set a callback that, right before re-render, re-runs select2? */
    /* $(function () {
//     document.addEventListener("DOMContentLoaded", function () {
        // THIS DOESN'T EVER FIRE!
        console.warn("Livewire has loaded; adding element.updated hook!")
        // return false; // FIXME
        Livewire.hook('element.updated', function (element, component) { //weird. doesn't seem to be firing?
            console.warn("Re-select-2'ing all select2's!")
            //$('.livewire-select2').select2('destroy').select2(); // TODO - this repeats in the script block above.

        })
    })
*/
//I don't think this fires either
document.addEventListener("livewire:load", () => {
    console.warn("livewire loaded!!!")
    Livewire.hook('message.processed', (message, component) => {
        console.warn("livewire message processed!")
       // $('.form-select').select2()

    }); });


//document.addEventListener("livewire:load", function (event) {
// OMG THIS ACTUALLY WORKS! (Kinda?)
    window.livewire.hook('message.processed', /*'element.updated',*/ (el,component) => {
        console.warn("hook fired!!!!!!!!!!!! on: "+el)
        $('.livewire-select2').select2();
    });
//});


// console.dir(Livewire)
// Livewire().hook('element.updated', function (element, component) { //weird. doesn't seem to be firing?
//     console.warn("Re-select-2'ing all select2's! (native embeded version?")
//     //$('.livewire-select2').select2('destroy').select2(); // TODO - this repeats in the script block above.
//
// })

// })
// window.setTimeout(  function () {
//     console.warn("Livewire has loaded; adding element.updated hook! (via DELAY!)")
//     return false; // FIXME TOO
//     Livewire.hook('element.updated', function (element, component) {
//         console.warn("Re-select-2'ing all select2's!")
//         $('.livewire-select2').select2('destroy').select2(); // TODO - this repeats in the script block above.
//
//     })
// },3000) // FIXME - this is stupid.
</script>