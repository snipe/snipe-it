<style>
tr {
    padding-left:30px;
}
</style>

<template>
    <tr v-show="processDetail">
        <td colspan="3">
            <h4 class="modal-title">{{ $t('importer.import.import_file') }}</h4>
            <div class="dynamic-form-row">
                <div class="col-md-4 col-xs-12">
                    <label for="import-type">{{ $t('importer.import.import_type') }}:</label>
                </div>
                <div class="col-md-4 col-xs-12">
                    <select2 :options="options.importTypes" v-model="options.importType">
                        <option disabled value="0"></option>
                    </select2>
                </div>
            </div>
            <div class="dynamic-form-row">
                <div class="col-md-4 col-xs-12">
                    <label for="import-update">{{ $t('importer.import.update_existing') }}</label>
                </div>
                <div class="col-md-4 col-xs-12">
                    <input type="checkbox" name="import-update" v-model="options.update">
                </div>
            </div>

            <div class="col-md-12" style="padding-top: 30px;">
            <table class="table">
            <thead>
                <th>{{ $t('importer.import.header_field') }}</th>
                <th>{{ $t('importer.import.import_field') }}</th>
                <th>{{ $t('importer.import.header_sample') }}</th>
            </thead>
            <tbody>
            <template v-for="(header, index) in file.header_row">
                <tr>
                    <td>
                    <label :for="header" class="controllabel">{{ header }}</label>
                    </td>
                    <td>
                        <div required>
                            <select2 :options="columns" v-model="columnMappings[header]">
                                <option value="0">{{ $t('importer.import.no_import') }}</option>
                            </select2>
                        </div>
                    </td>
                    <td>
                        <div>{{ activeFile.first_row[index] }}</div>
                    </td>
                </tr>
                </template>
            </tbody>
            </table>
            </div>
        </td>

        <td>
            <button type="button" class="btn btn-sm btn-default" @click="processDetail = false">{{ $t('general.cancel') }}</button>
            <button type="submit" class="btn btn-sm btn-primary" @click="postSave">{{ $t('importer.import.process') }}</button>
            <div class="alert alert-success col-md-5 col-md-offset-1" style="text-align:left" v-if="statusText">{{ this.statusText }}</div>
        </td>
    </tr>
</template>

<script>
    export default {
        props: ['file', 'customFields'],
        data() {
            return {
                activeFile: this.file,
                processDetail: false,
                statusText: null,
                options: {
                    importType: this.file.import_type,
                    update: false,
                    importTypes: [
                        { id: 'asset', text: this.$t('general.assets') },
                        { id: 'accessory', text: this.$t('general.accessories') },
                        { id: 'consumable', text: this.$t('general.consumables') },
                        { id: 'component', text: this.$t('general.components') },
                        { id: 'license', text: this.$t('general.licenses') },
                        { id: 'user', text: this.$t('general.users') }
                    ],
                    statusText: null,
                },
                columnOptions: {
                    general: [
                        {id: 'category', text: this.$t('general.category') },
                        {id: 'company', text: this.$t('general.company') },
                        {id: 'checkout_to', text: this.$t('admin.hardware.form.checkedout_to') },
                        {id: 'email', text: this.$t('admin.users.table.email') },
                        {id: 'first_name', text: this.$t('general.first_name') },
                        {id: 'item_name', text: this.$t('general.item_name') },
                        {id: 'last_name', text: this.$t('general.last_name') },
                        {id: 'location', text: this.$t('general.location') },
                        {id: 'maintained', text: this.$t('admin.licenses.form.maintained') },
                        {id: 'manufacturer', text: this.$t('general.manufacturer') },
                        {id: 'notes', text: this.$t('general.notes') },
                        {id: 'order_number', text: this.$t('general.order_number') },
                        {id: 'purchase_cost', text: this.$t('general.purchase_cost') },
                        {id: 'purchase_date', text: this.$t('general.purchase_date') },
                        {id: 'quantity', text: this.$t('general.quantity') },
                        {id: 'requestable', text: this.$t('admin.hardware.general.requestable') },
                        {id: 'serial', text: this.$t('admin.hardware.form.serial') },
                        {id: 'supplier', text: this.$t('general.supplier') },
                        {id: 'username', text: this.$t('mail.username') },
                    ],
                    assets: [
                        {id: 'asset_tag', text: this.$t('admin.hardware.table.asset_tag') },
                        {id: 'asset_model', text: this.$t('admin.models.table.name') },
                        {id: 'image', text: this.$t('general.image') },
                        {id: 'model_number', text: this.$t('general.model_no') },
                        {id: 'name', text: this.$t('importer.import.full_name') },
                        {id: 'status', text: this.$t('general.status') },
                        {id: 'warranty_months', text: this.$t('admin.hardware.form.warranty') },
                    ],
                    licenses: [
                        {id: 'expiration_date', text: this.$t('admin.licenses.form.expiration') },
                        {id: 'license_email', text: this.$t('admin.licenses.form.to_name') },
                        {id: 'license_name', text: this.$t('admin.licenses.form.to_email') },
                        {id: 'purchase_order', text: this.$t('admin.licenses.form.purchase_order') },
                        {id: 'reassignable', text: this.$t('admin.licenses.form.reassignable') },
                        {id: 'seats', text: this.$t('admin.licenses.form.seats') },
                    ],
                    users: [
                        {id: 'employee_num', text: this.$t('admin.users.table.employee_num') },
                        {id: 'jobtitle', text: this.$t('admin.users.table.job') },
                        {id: 'phone_number', text: this.$t('admin.users.table.phone') },
                    ],
                    customFields: this.customFields,
                },
                columnMappings: this.file.field_map || {},
                activeColumn: null,
            }
        },
        created() {
            window.eventHub.$on('showDetails', this.toggleExtendedDisplay)
            this.populateSelect2ActiveItems();
        },
        computed: {
            columns() {
                switch(this.options.importType) {
                    case 'asset':
                        return this.columnOptions.general.concat(this.columnOptions.assets).concat(this.columnOptions.customFields);
                    case 'license':
                        return this.columnOptions.general.concat(this.columnOptions.licenses);
                    case 'user':
                        return this.columnOptions.general.concat(this.columnOptions.users);
                }
                return this.columnOptions.general;
            }
        },
        methods: {
            postSave() {
                this.statusText = this.$t('general.processing');
                this.$http.post(route('api.imports.importFile', this.file.id), {
                    'import-update': this.options.update,
                    'import-type': this.options.importType,
                    'column-mappings': this.columnMappings
                }).then( ({body}) => {
                    // Success
                    this.statusText = this.$t('importer.import.import_success');
                    window.location.href = body.messages.redirect_url;
                }, ({body}) => {
                    // Failure
                    if(body.status == 'import-errors') {
                        window.eventHub.$emit('importErrors', body.messages);
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
                        let index = this.file.header_row.indexOf(column.text)
                        if(index != -1) {
                            this.$set(this.columnMappings, this.file.header_row[index], column.id)
                        }
                    }
                }
            },
            toggleExtendedDisplay(fileId) {
                if(fileId == this.file.id) {
                    this.processDetail = !this.processDetail
                }
            },
            updateModel(header, value) {
                console.log(header, value);
                this.columnMappings[header] = value;
            }
        },
        components: {
            select2: require('../select2.vue')
        }
    }
</script>
