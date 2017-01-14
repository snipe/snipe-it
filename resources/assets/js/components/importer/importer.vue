
<style scoped>
</style>

<template>
    <div>
        <alert v-show="alert.visible" :alertType="alert.type" v-on:hide="alert.visible = false">{{ alert.message }}</alert>
        <errors :errors="importErrors"></errors>
        <modal v-model="displayImportModal" effect="fade">
            <div slot="modal-header" class="modal-title">Import File:</div>
            <div slot="modal-body" class="modal-body">
                <div class="dynamic-form-row">
                    <div class="col-md-4 col-xs-12">
                      <label for="import-type">Import Type:</label>
                    </div>
                    <div class="col-md-8 col-xs-12">
                       <!--  <select v-model="modal.importType" class="select2" style="width:100%;">
                            <option v-for="type in modal.importTypes" v-bind:value="type.value">{{ type.text }}</option>
                        </select> -->
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
                <div class="col-md-8 alert-success" v-if="modal.statusText">{{ this.modal.statusText }}</div>
            </div>

            <div slot="modal-footer" class="modal-footer">
                <button type="button" class="btn btn-default" @click="displayImportModal = false">Cancel</button>
                <button type="submit" class="btn btn-primary" id="modal-save" @click="postSave">Save</button>
            </div>
        </modal>
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-body">
                        <div class="col-md-3">
                            <!-- The fileinput-button span is used to style the file input field as button -->
                            <span class="btn btn-info fileinput-button">
                                <i class="fa fa-plus icon-white"></i>
                                <!-- The file input field used as target for the file upload widget -->
                                <input id="fileupload" type="file" name="files[]" data-url="/api/v1/imports">
                            </span>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <table class="table table-striped" id="upload-table">
                                    <thead>
                                        <th>File</th>
                                        <th>Created</th>
                                        <th>Size</th>
                                        <th></th>
                                    </thead>
                                    <tbody>
                                        <tr v-for="file in files">
                                            <td>{{ file.file_path }}</td>
                                            <td>{{ file.created_at }} </td>
                                            <td>{{ file.filesize }}</td>
                                            <td>
                                                <button class="btn btn-sm btn-info" @click="showModal(file)"><i class="fa fa-spinner process"></i>Process</button>
                                                <button class="btn btn-danger btn-sm" @click="deleteFile(file)"><i class="fa fa-trash icon-white"></i></button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    require('blueimp-file-upload');
    var modal = require('vue-strap').modal
    export default {
        /*
         * The component's data.
         */
        data() {
            return {
                files: [],
                displayImportModal: false,
                activeFile: null,
                alert: {
                    type: null,
                    message: null,
                    visible: false,
                },
                modal: {
                    importType: 0,
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
                importErrors: null
            };
        },

        /**
         * Prepare the component (Vue 2.x).
         */
        mounted() {
            this.fetchFiles();
            let vm = this;
            $('#fileupload').fileupload({
                dataType: 'json',
                done(e, data) {
                    vm.files = data.result.files.concat(vm.files);
                },
                add(e, data) {
                    data.headers = {
                        "X-Requested-With": 'XMLHttpRequest',
                        "X-CSRF-TOKEN": Laravel.csrfToken
                    };
                    if (data.autoUpload || (data.autoUpload !== false && $(this).fileupload('option', 'autoUpload'))) {
                        data.process().done( () => {data.submit();});
                    }
                }
            })
        },

        methods: {
            fetchFiles() {
                this.$http.get('/api/v1/imports')
                .then( ({data}) => this.files = data)
            },
            deleteFile(file, key) {
                this.$http.delete("/api/v1/imports/"+file.id)
                .then( (response) => this.files.splice(key, 1) )
            },
            showModal(file) {
                this.activeFile = file;
                this.displayImportModal = true;
            },

            postSave() {
                console.log("Saving");
                this.$http.post('/api/v1/imports/process/'+this.activeFile.id, {
                    'import-update': this.modal.update,
                    'import-type': this.modal.importType.value
                }).then( (response) => {
                    // Success
                    console.dir(response);
                    this.modal.statusText = "Success...";
                    window.location.href = response.body.messages.redirect_url;
                }, (response) => {
                    // Failure
                    console.dir(response);
                    this.importErrors = response.body.messages;
                    this.alert.type="danger";
                    this.alert.message= "An error has occured";
                    this.alert.visible=true;
                    this.displayImportModal=false;
                });
            }

        },

        components: {
            modal,
            errors: require('./errors.vue'),
            alert: require('../alert.vue'),
            select2: require('../select2.vue')
        }
    }

</script>
