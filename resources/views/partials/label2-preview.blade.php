@once
    @push('css')
        <style>
            :root {
                --l2p-height: 400px;
                --l2p-background-color: aliceblue;
            }

            .l2p-root,
            .l2p-root * {
                box-sizing: border-box;
            }

            .l2p-root {
                width: 100%;
                height: var(--l2p-height);
                display: flex;
                flex-direction: column;
            }

            .l2p-root > label {
                font-size: 0.9em;
                padding: 0;
                margin: 0;
            }

            .l2p-root > iframe {
                flex: 1;
                overflow: auto;
                background-color: var(--l2p-background-color);
            }
        </style>
    @endpush
@endonce

@push('js')
    <script>
        document.addEventListener('alpine:init', () => {

            Alpine.data('label2_preview', () => ({

                _form: null,
                _init: function() {
                    this._form = this.$root.closest('form');
                    this._form.addEventListener('change', this.updateURL.bind(this));
                },

                updateURL: function() {

                    let params = {
                        settings: Object.assign({}, ...$(this._form)
                            .serializeArray()
                            .filter((value, index, all) => value.name.includes('label2_'))
                            .map((value, index, all) => ({[value.name]: value.value}))
                            )
                    };

                    let template = params.settings.label2_template;
                    if (!template) return;

                    this.previewURL = '{{ route("labels.show", ["labelName" => ":label"]) }}'
                        .replace(':label', template.replaceAll('\\', '/'))
                        .concat('?', $.param(params), '#toolbar=0');
                },

                previewURL: ''
            }));

        });
    </script>
@endpush

<div x-data="label2_preview" x-init="_init" class="l2p-root">
    <label for="label2-preview">Preview</label>
    <iframe id="label2-preview" x-bind:src="previewURL"></iframe>
</div>
