{{-- <template> --}}

  <tr>
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
                <div class="alert col-md-8 col-md-offset-2 {{ $statusType == 'success' ? 'alert-success' : ($statusType == 'error' ? 'alert-danger' : 'alert-info') }}" style="text-align:left">
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
                <div class="row" wire:key="header-row-{{ $increment }}">
                    <div class="col-md-12">
                        <div class="col-md-4 text-right">
                            <label for="field_map.{{ $index }}" class="control-label">{{ $header }}</label>
                        </div>
                        <div class="col-md-4 form-group">
                            <div required data-force-refresh="{{ $increment }}">
                                {{-- this, along with the JS glue below, is quite possibly near to the new Universal LW2 stuff? --}}
                                {{ Form::select('field_map.'.$index, $columnOptions[$activeFile->import_type], @$activeFile->field_map[$header],
                                    [
                                        'class' => 'mappings livewire-select2',
                                        'data-livewire-model' => 'field_map.'.$index, // start of a 'universal' way to do this?
                                        'placeholder' => 'Do Not Import'
                                    ])

                                }}
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
  </tr>
{{-- </template> --}}
<script>
    $('#import').on('click', function () {
        console.log('saving');
        console.log(@this.activeFile.import_type);
        if(!@this.activeFile.import_type) {
            @this.statusType='error';
            @this.statusText= "An import type is required... ";
            return;
        }
        @this.statusType='pending';
        @this.statusText = "Processing...";
        @this.getDinglefartsProperty().then(function (mappings_raw) {
            var mappings = JSON.parse(mappings_raw)
            console.warn("Here is the mappings:")
            console.dir(mappings)
            $.post({
                url: "{{ route('api.imports.importFile', $activeFile->id) }}",
                data: {
                    'import-update': !!@this.update,
                    'send-welcome': !!@this.send_welcome,
                    'import-type': @this.activeFile.import_type,
                    'run-backup': !!@this.run_backup,
                    'column-mappings': mappings // THE HARD PART.
                },
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
                @this.emit('hideDetails') // emit something ?
            });
        })
        return false;
    });

    $(function () {
    console.warn("Setting iCheck callbacks!")
    $('.iCheck').on('ifToggled', function (event) {
        console.warn("iCheck checked!")
        console.dir(event.target)
        @this.set(event.target.name, event.target.checked)
    })
})

$('.livewire-select2').select2(); // TODO/FIXME (pick one) possibly embedded into the Universal Livewire Implementation

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