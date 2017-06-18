<style>
tr {
    padding-left:30px;
}
</style>

<template>
    <tr v-show="processDetail">
        <td colspan="3">
            <h4 class="modal-title">Import File:</h4>
            <div class="dynamic-form-row">
                <div class="col-md-4 col-xs-12">
                    <label for="import-type">Import Type:</label>
                </div>
                <div class="col-md-4 col-xs-12">
                    <select2 :options="options.importTypes" v-model="options.importType">
                        <option disabled value="0"></option>
                    </select2>
                </div>
            </div>
            <div class="dynamic-form-row">
                <div class="col-md-4 col-xs-12">
                    <label for="import-update">Update Existing Values?:</label>
                </div>
                <div class="col-md-4 col-xs-12">
                    <input type="checkbox" name="import-update" v-model="options.update">
                </div>
            </div>

            <div class="col-md-12" style="padding-top: 30px;">
            <table class="table">
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
            </div>
        </td>

        <td>
            <button type="button" class="btn btn-default" @click="processDetail = false">Cancel</button>
            <button type="submit" class="btn btn-primary" @click="postSave">Import</button>
            <div class="alert alert-success col-md-5 col-md-offset-1" style="text-align:left" v-if="statusText">{{ this.statusText }}</div>
        </td>
    </tr>
</template>

<script>
    export default {
        props: ['file'],
        data() {
            return {
                activeFile: this.file,
                processDetail: false,
                statusText: null,
                options: {
                    importType: 'asset',
                    update: false,
                    importTypes: [
                        { id: 'asset', text: 'Assets' },
                        { id: 'accessory', text: 'Accessories' },
                        { id: 'consumable', text: 'Consumable' },
                        { id: 'component', text: 'Components' },
                        { id: 'license', text: 'Licenses' }
                    ],
                    statusText: null,
                },
                columns: [
                    {id: 'asset_tag', text: 'Asset Tag' },
                    {id: 'category', text: 'Category' },
                    {id: 'company', text: 'Company' },
                    {id: 'checkout_to', text: 'Checked out to' },
                    {id: 'expiration_date', text: 'Expiration Date' },
                    {id: 'image', text: 'Image Filename' },
                    {id: 'license_email', text: 'Licensed To Email' },
                    {id: 'license_name', text: 'Licensed To Name' },
                    {id: 'location', text: 'Location' },
                    {id: 'maintained', text: 'Maintained' },
                    {id: 'manufacturer', text: 'Manufacturer' },
                    {id: 'asset_model', text: 'Model Name' },
                    {id: 'model_number', text: 'Model Number' },
                    {id: 'item_name', text: 'Item Name' },
                    {id: 'notes', text: 'Notes' },
                    {id: 'order_number', text: 'Order Number' },
                    {id: 'purchase_cost', text: 'Purchase Cost' },
                    {id: 'purchase_date', text: 'Purchase Date' },
                    {id: 'purchase_order', text: 'Purchase Order' },
                    {id: 'quantity', text: 'Quantity' },
                    {id: 'reassignable', text: 'Reassignable' },
                    {id: 'requestable', text: 'Requestable' },
                    {id: 'seats', text: 'Seats' },
                    {id: 'serial', text: 'Serial Number' },
                    {id: 'status', text: 'Status' },
                    {id: 'supplier', text: 'Supplier' },
                    {id: 'user_email', text: 'Email' },
                    {id: 'username', text: 'Username' },
                    {id: 'warranty_months', text: 'Warranty Months' },
                ],
                columnMappings: {},
                activeColumn: null,
            }
        },
        created() {
            window.eventHub.$on('showDetails', this.toggleExtendedDisplay)

            for (var i=0; i < this.file.header_row.length; i++) {
                this.$set(this.columnMappings, this.file.header_row[i], null);
            }
            for(var j=0; j < this.columns.length; j++) {
                let column = this.columns[j];
                let index = this.file.header_row.indexOf(column.text)
                if(index != -1) {
                    this.$set(this.columnMappings, this.file.header_row[index], column.id)
                }
            }
        },

        methods: {
            postSave() {
                this.statusText = "Processing...";
                this.$http.post('/api/v1/imports/process/'+this.file.id, {
                    'import-update': this.options.update,
                    'import-type': this.options.importType,
                    'column-mappings': this.columnMappings
                }).then( (response) => {
                    // Success
                    this.statusText = "Success... Redirecting.";
                    window.location.href = response.body.messages.redirect_url;
                }, (response) => {
                    // Failure
                    if(response.body.status == 'import-errors') {
                        window.eventHub.$emit('importErrors', response.body.messages);
                        this.statusText = "Error";
                    } else {
                        this.$emit('alert', {
                            message: response.body.messages,
                            type: "danger",
                            visible: true,
                        })
                    }
                    this.displayImportModal=false;
                });
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