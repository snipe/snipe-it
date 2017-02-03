
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
            </div>

            <div slot="modal-footer" class="modal-footer">
                <div class="row">
                    <div class="alert alert-success col-md-5 col-md-offset-1" style="text-align:left" v-if="modal.statusText">{{ this.modal.statusText }}</div>
                    <button type="button" class="btn btn-default" @click="displayImportModal = false">Cancel</button>
                    <button type="submit" class="btn btn-primary" @click="postSave">Save</button>
                </div>
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
                                <span>Select Import File...</span>
                                <!-- The file input field used as target for the file upload widget -->
                                <input id="fileupload" type="file" name="files[]" data-url="/api/v1/imports" accept="text/csv">
                            </span>
                        </div>
                        <div class="col-md-9" v-show="progress.visible" style="padding-bottom:20px">
                            <div class="col-md-11">
                                <div class="progress progress-striped-active" style="margin-top: 8px">
                                    <div class="progress-bar" :class="progress.currentClass" role="progressbar" :style="progressWidth">
                                        <span>{{ progress.statusText }}</span>
                                    </div>
                                </div>
                            </div>
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
                                                <button class="btn btn-sm btn-danger" @click="deleteFile(file)"><i class="fa fa-trash icon-white"></i></button>
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
                importErrors: null,
                progress: {
                    currentClass: "progress-bar-warning",
                    currentPercent: "0",
                    statusText: '',
                    visible: false
                }
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
                    vm.progress.currentClass="progress-bar-success";
                    vm.progress.statusText = "Success!";
                    vm.files = data.result.files.concat(vm.files);
                },
                add(e, data) {
                    data.headers = {
                        "X-Requested-With": 'XMLHttpRequest',
                        "X-CSRF-TOKEN": Laravel.csrfToken
                    };
                    data.process().done( () => {data.submit();});
                    vm.progress.visible=true;
                },
                progress(e, data) {
                    var progress = parseInt((data.loaded / data.total * 100, 10));
                    vm.progress.currentPercent = progress;
                    vm.progress.statusText = progress+'% Complete';
                },
                fail(e, data) {
                    vm.progress.currentClass = "progress-bar-danger";
                    vm.progress.statusText = data.errorThrown;
                }
            })
        },

        methods: {
            fetchFiles() {
                this.$http.get('/api/v1/imports')
                .then( ({data}) => this.files = data, // Success
                    //Fail
                (response) => {
                    this.alert.type="danger";
                    this.alert.visible=true;
                    this.alert.message="Something went wrong fetching files...";
                });
            },
            deleteFile(file, key) {
                this.$http.delete("/api/v1/imports/"+file.id)
                .then((response) => this.files.splice(key, 1), // Success
                    (response) => {// Fail
                        this.alert.type="danger";
                        this.alert.visible=true;
                        this.alert.message=response.body.messages;
                    }
                );
            },
            showModal(file) {
                this.activeFile = file;
                this.displayImportModal = true;
            },

            postSave() {
                this.$http.post('/api/v1/imports/process/'+this.activeFile.id, {
                    'import-update': this.modal.update,
                    'import-type': this.modal.importType
                }).then( (response) => {
                    // Success
                    this.modal.statusText = "Success... Redirecting.";
                    window.location.href = response.body.messages.redirect_url;
                }, (response) => {
                    // Failure
                    if(response.body.status == 'import-errors') {
                        this.importErrors = response.body.messages;
                    } else {
                        this.alert.message= response.body.messages;
                        this.alert.type="danger";
                        this.alert.visible=true;
                    }
                    this.displayImportModal=false;
                });
            }

        },

        computed: {
            progressWidth() {
                return "width: "+this.progress.currentPercent*10+'%';
            }
        },

        components: {
            modal,
            errors: require('./importer-errors.vue'),
            alert: require('../alert.vue'),
            select2: require('../select2.vue')
        }
    }

</script>
