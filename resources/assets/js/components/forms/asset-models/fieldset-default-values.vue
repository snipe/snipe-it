<style scoped>
    legend {
        font-size: 13px;
        font-weight: bold;
        border: 0;
    }


    fieldset > div {
        background: #f4f4f4;
        border: 1px solid #d3d6de;
        margin: 0 15px 15px;
        padding: 20px 20px 10px;
    }

    @media (max-width: 992px) {
        legend {
            text-align: left !important;
        }
    }

    @media (min-width: 992px) {
        fieldset > div {
            width: 55%;
        }
    }


</style>

<template>
    <div>
        <div v-if="show && fields.length">
            <div class="form-group">
                <fieldset>
                    <legend class="col-md-3 control-label">Default Values</legend>
                    <div class="col-sm-8 col-xl-7">
                        <p v-if="error">
                            There was a problem retrieving the fields for this fieldset.
                        </p>
                        <div class="row" v-for="field in fields">
                            <div class="col-sm-12 col-lg-6">
                                <label class="control-label" :for="'default-value' + field.id">{{ field.name }}</label>
                            </div>
                            <div class="col-sm-12 col-lg-6">
                                <input v-if="field.type == 'text'" class="form-control m-b-xs" type="text" :value="getValue(field)" :id="'default-value' + field.id" :name="'default_values[' + field.id + ']'">
                                <textarea v-if="field.type == 'textarea'" class="form-control" :value="getValue(field)" :id="'default-value' + field.id" :name="'default_values[' + field.id + ']'"></textarea><br>

                                <select v-if="field.type == 'listbox'" class="form-control m-b-xs" :name="'default_values[' + field.id + ']'">
                                    <option value=""></option>
                                    <option v-for="field_value in field.field_values_array" :value="field_value" :selected="getValue(field) == field_value">{{ field_value }}</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </fieldset>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: [
            'fieldsetId',
            'modelId',
            'previousInput',
        ],

        data() {
            return {
                identifiers: {
                    fieldset: null,
                    model: null,
                },
                elements: {
                    fieldset: null,
                    field: null,
                },
                fields: null,
                show: false,
                error: false,
            }
        },

        /**
         * Initialise the component (Vue 1.x).
         */
        ready() {
            this.init()
        },

        /**
         * Initialise the component (Vue 2.x).
         */
        mounted() {
            this.init()
        },

        methods: {
            /**
             * Grabs the toggle field and connected fieldset and if present,
             * set up the rest of the component. Scope lookups to the component
             * only so we're not traversing and/or manipulating the whole DOM
             */
            init() {
                this.defaultValues = JSON.parse(this.previousInput);
                this.identifiers.fieldset = this.fieldsetId
                this.identifiers.model = this.modelId

                // This has to be jQuery because a lot of native functions/events
                // do not work with select2
                this.elements.fieldset = $('.js-fieldset-field')

                this.elements.field = document.querySelector('.js-default-values-toggler')

                if (this.elements.fieldset && this.elements.field) {
                    this.addListeners()
                    this.getFields()

                }
            },

            /**
             * Adds event listeners for:
             *     - Toggle field changing
             *     - Fieldset field changing
             *
             * Using jQuery event hooks for the select2 fieldset field as
             * select2 does not emit DOM events...
             */
            addListeners() {
                this.elements.field.addEventListener('change', e => this.updateShow())
                this.elements.fieldset.on('change', e => this.updateFields())
            },

            /**
             * Call the CustomFieldsetsController::fields() endpoint to grab
             * the fields we can set default values for
             */
            getFields() {
                if (!this.identifiers.fieldset) {
                    return this.fields = [];
                }

                this.$http.get(this.getUrl())
                    .then(response => response.json())
                    .then(data => this.checkResponseForError(data))
                    .then(data => this.fields = data.rows)
                    .then(() => this.determineIfShouldShow())
            },

            getValue(field) {
                if (field.default_value) {
                    return field.default_value
                }

                return this.defaultValues != null ? this.defaultValues[field.id.toString()] : ''
            },

            /**
             * Generates the API URL depending on what information is available
             *
             * @return Router
             */
            getUrl() {
                if (this.identifiers.model) {
                    return route('api.fieldsets.fields-with-default-value', {
                        fieldset: this.identifiers.fieldset,
                        model: this.identifiers.model,
                    })
                }

                return route('api.fieldsets.fields', {
                    fieldset: this.identifiers.fieldset,
                })
            },

            /**
             * Sets error state and shows error if request was not marked
             * successful
             */
            checkResponseForError(data) {
                this.error = data.status == 'error'

                return data
            },

            /**
             * Checks whether the toggler is checked and shows the default
             * values field dependent on that
             */
            updateShow() {
                if (this.identifiers.fieldset && this.elements.field) {
                    this.show = this.elements.field.checked
                }
            },

            /**
             * checks the 'add default values' checkbox if it is already checked
             * OR this.show is already set to true OR if any fields already have
             * a default value.
             */
            determineIfShouldShow() {
                this.elements.field.checked = this.elements.field.checked
                    || this.show
                    || this.fields.reduce((accumulator, currentValue) => {
                        return accumulator || currentValue.default_value
                    }, false)

                this.updateShow()
            },

            updateFields() {
                this.identifiers.fieldset = this.elements.fieldset[0].value ? parseInt(this.elements.fieldset[0].value) : false
                this.getFields()
            },
        }
    }
</script>
