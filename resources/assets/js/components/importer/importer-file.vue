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
                <div class="col-md-8 col-xs-12">
                    <select2 :options="modal.importTypes" v-model="modal.importType">
                        <option disabled value="0"></option>
                    </select2>
                </div>
            </div>
            <div class="dynamic-form-row">
                <div class="col-md-4 col-xs-12">
                    <label for="import-update">Update Existing Values?:</label>
                </div>
                <div class="col-md-8 col-xs-12">
                    <input type="checkbox" name="import-update" v-model="modal.update">
                </div>
            </div>
        </td>
        <td>
            <div class="footer" slot="footer">
                <div class="alert alert-success col-md-5 col-md-offset-1" style="text-align:left" v-if="statusText">@{{ this.statusText }}</div>
                <button type="button" class="btn btn-default" @click="processDetail = false">Cancel</button>
                <button type="submit" class="btn btn-primary" @click="postSave">Import</button>
            </div>
        </td>
    </tr>
</template>

<script>
    export default {
        props: ['file'],
        data() {
            return {
                processDetail: false,
                statusText: null,
                modal: {
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
            }
        },

        created() {
            window.eventHub.$on('showDetails', this.toggleExtendedDisplay)
        },

        methods: {
            postSave() {
                this.statusText = "Processing...";
                this.$http.post('/api/v1/imports/process/'+this.activeFile.id, {
                    'import-update': this.modal.update,
                    'import-type': this.modal.importType
                }).then( (response) => {
                    // Success
                    this.statusText = "Success... Redirecting.";
                    window.location.href = response.body.messages.redirect_url;
                }, (response) => {
                    // Failure
                    if(response.body.status == 'import-errors') {
                        this.importErrors = response.body.messages;
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
        },
        components: {
            select2: require('../select2.vue')
        }
    }
</script>