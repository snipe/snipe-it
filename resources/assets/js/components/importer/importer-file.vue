<style>
tr {
    padding-left:30px;
}
</style>

<template>
    <tr v-show="processDetail">
        <td colspan="5">
            <div class="col-md-2 text-left">
            </div>
            <div class="col-md-8 col-md-offset-2 text-center" style="padding-top: 30px; margin: 0 auto;">
            <div class="col-md-12 text-left">

            <h4 class="modal-title">Import File:</h4>
            <div class="dynamic-form-row">
                <div class="col-md-5 col-xs-12">
                    <label for="import-type">Import Type:</label>
                </div>
                <div class="col-md-7 col-xs-12">
                    <select2 :options="options.importTypes" v-model="options.importType" required>
                        <option disabled value="0"></option>
                    </select2>
                </div>
            </div>
            <div class="dynamic-form-row">
                <div class="col-md-5 col-xs-12">
                    <label for="import-update">Update Existing Values?:</label>
                </div>
                <div class="col-md-7 col-xs-12">
                    <input type="checkbox" name="import-update" v-model="options.update">
                </div>
            </div>
            <div class="dynamic-form-row">
                <div class="col-md-5 col-xs-12">
                    <label for="send-welcome">Send Welcome Email for new Users?</label>
                </div>
                <div class="col-md-7 col-xs-12">
                    <input type="checkbox" name="send-welcome" v-model="options.send_welcome">
                </div>
                </div>
            </div>
            <div class="alert col-md-12" style="text-align:left"
                 :class="alertClass"
                 v-if="statusText">
                {{ this.statusText }}
            </div>


            <div class="text-left" style="padding-top: 30px;">
            <table class="table table-striped snipe-table">
            <thead>
                <th>Header Field</th>
                <th>Import Field</th>
                <th>Sample Value</th>
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
                                <option value="0">Do Not Import</option>
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
                <br>
                 <div class="col-md-8 col-md-offset-2 text-right">
                     <button type="button" class="btn btn-sm btn-default" @click="processDetail = false">Cancel</button>
                     <button type="submit" class="btn btn-sm btn-primary" @click="postSave">Import</button>
                     <br><br>
                 </div>

                <div class="alert col-md-12" style="padding-top: 20px;"
                     :class="alertClass"
                     v-if="statusText">
                    {{ this.statusText }}
                </div>

             </div>
            </div>

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
                statusType: null,
                options: {
                    importType: this.file.import_type,
                    update: false,
                    importTypes: [
                        { id: 'asset', text: 'Assets' },
                        { id: 'accessory', text: 'Accessories' },
                        { id: 'consumable', text: 'Consumables' },
                        { id: 'component', text: 'Components' },
                        { id: 'license', text: 'Licenses' },
                        { id: 'user', text: 'Users' }
                    ],
                    statusText: null,
                },
                columnOptions: {
                    general: [
                        {id: 'category', text: 'Category' },
                        {id: 'company', text: 'Company' },
                        {id: 'checkout_to', text: 'Checked out to' },
                        {id: 'email', text: 'Email' },
                        {id: 'item_name', text: 'Item Name' },
                        {id: 'location', text: 'Location' },
                        {id: 'maintained', text: 'Maintained' },
                        {id: 'manufacturer', text: 'Manufacturer' },
                        {id: 'notes', text: 'Notes' },
                        {id: 'order_number', text: 'Order Number' },
                        {id: 'purchase_cost', text: 'Purchase Cost' },
                        {id: 'purchase_date', text: 'Purchase Date' },
                        {id: 'quantity', text: 'Quantity' },
                        {id: 'requestable', text: 'Requestable' },
                        {id: 'serial', text: 'Serial Number' },
                        {id: 'supplier', text: 'Supplier' },
                        {id: 'username', text: 'Username' },
                        {id: 'department', text: 'Department' },
                    ],
                    assets: [
                        {id: 'asset_tag', text: 'Asset Tag' },
                        {id: 'asset_model', text: 'Model Name' },
                        {id: 'checkout_class', text: 'Checkout Type' },
                        {id: 'checkout_location', text: 'Checkout Location' },
                        {id: 'image', text: 'Image Filename' },
                        {id: 'model_number', text: 'Model Number' },
                        {id: 'full_name', text: 'Full Name' },
                        {id: 'status', text: 'Status' },
                        {id: 'warranty_months', text: 'Warranty Months' },
                    ],
                    consumables: [
                        {id: 'item_no', text: "Item Number"},
                        {id: 'model_number', text: "Model Number"},
                    ],
                    licenses: [
                        {id: 'expiration_date', text: 'Expiration Date' },
                        {id: 'license_email', text: 'Licensed To Email' },
                        {id: 'license_name', text: 'Licensed To Name' },
                        {id: 'purchase_order', text: 'Purchase Order' },
                        {id: 'reassignable', text: 'Reassignable' },
                        {id: 'seats', text: 'Seats' },
                    ],
                    users: [
                        {id: 'employee_num', text: 'Employee Number' },
                        {id: 'first_name', text: 'First Name' },
                        {id: 'jobtitle', text: 'Job Title' },
                        {id: 'last_name', text: 'Last Name' },
                        {id: 'phone_number', text: 'Phone Number' },
                        {id: 'manager_first_name', text: 'Manager First Name' },
                        {id: 'manager_last_name', text: 'Manager Last Name' },
                        {id: 'activated', text: 'Activated' },

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
                // function to sort objects by their display text.
                function sorter(a,b) {
                    if (a.text < b.text)
                        return -1;
                    if (a.text > b.text)
                        return 1;
                    return 0;
                }
                switch(this.options.importType) {
                    case 'asset':
                        return this.columnOptions.general
                                .concat(this.columnOptions.assets)
                                .concat(this.columnOptions.customFields)
                                .sort(sorter);

                    case 'consumable':
                        return this.columnOptions.general
                        .concat(this.columnOptions.consumables)
                        .sort(sorter);
                    case 'license':
                        return this.columnOptions.general.concat(this.columnOptions.licenses).sort(sorter);
                    case 'user':
                        return this.columnOptions.general.concat(this.columnOptions.users).sort(sorter);
                }
                return this.columnOptions.general;
            },
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
            toggleExtendedDisplay(fileId) {
                if(fileId == this.file.id) {
                    this.processDetail = !this.processDetail
                }
            },
            updateModel(header, value) {
                this.columnMappings[header] = value;
            }
        },
        components: {
            select2: require('../select2.vue')
        }
    }
</script>
