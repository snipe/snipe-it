<div>
    @foreach ($rows as $index => $row)
        <span class="fields_wrapper" wire:key="row-{{ $index }}">
            {{-- Additional asset tag input for row N. wire:model binds it to
                 the Livewire component state so add/remove doesn't clobber
                 the operator's typed values. The remove button rides in
                 x-form.row's after_input slot (col-md-1). --}}
            <x-form.row
                :label="trans('admin/hardware/form.tag').' '.$index"
                :name="'asset_tags.'.$index"
                input_div_class="col-md-7 col-sm-12 required"
            >
                <x-slot:input>
                    <x-input.text
                        name="asset_tags[{{ $index }}]"
                        id="asset_tag_{{ $index }}"
                        wire:model="rows.{{ $index }}.asset_tag"
                        required
                    />
                </x-slot:input>
                <x-slot:after_input>
                    <a href="#" wire:click.prevent="removeRow({{ $index }})" class="btn btn-sm btn-theme">
                        <x-icon type="minus" />
                        <span class="sr-only">{{ trans('button.delete') }}</span>
                    </a>
                </x-slot:after_input>
            </x-form.row>

            {{-- Additional serial input for row N. --}}
            <x-form.row
                :label="trans('admin/hardware/form.serial').' '.$index"
                :name="'serials.'.$index"
                input_div_class="col-md-7 col-sm-12"
            >
                <x-slot:input>
                    <x-input.text
                        name="serials[{{ $index }}]"
                        id="serial_{{ $index }}"
                        wire:model="rows.{{ $index }}.serial"
                    />
                </x-slot:input>
            </x-form.row>
        </span>
    @endforeach
</div>
