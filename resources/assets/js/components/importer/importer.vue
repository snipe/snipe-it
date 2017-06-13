<style scoped>
td {
    font-size: 13px;
}

th {
    font-size: 13px;
}
</style>

<script>
    require('blueimp-file-upload');
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
                    // Display any errors returned from the $.ajax()
                    vm.progress.statusText = data.jqXHR.responseJSON.messages;
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
                this.modal.statusText = "Processing...";
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
            },


            closeDialog() {
                this.displayImportModal = false;
            },

        },

        computed: {
            progressWidth() {
                return "width: "+this.progress.currentPercent*10+'%';
            }
        },

        components: {
            modal: require('../modal.vue'),
            errors: require('./importer-errors.vue'),
            alert: require('../alert.vue'),
            select2: require('../select2.vue')
        }
    }

</script>
