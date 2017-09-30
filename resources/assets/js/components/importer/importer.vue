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

        props: ['importUrl'],
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
                importErrors: null,
                progress: {
                    currentClass: "progress-bar-warning",
                    currentPercent: "0",
                    statusText: '',
                    visible: false
                }
            };
        },

        mounted() {
            window.eventHub.$on('importErrors', this.updateImportErrors);
            this.fetchFiles();
            let vm = this;
            $('#fileupload').fileupload({
                dataType: 'json',
                done(e, data) {
                    vm.progress.currentClass="progress-bar-success";
                    vm.progress.statusText = "Success!";
                    vm.files = data.result.files.concat(vm.files);
                    console.log(data.result.header_row);
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
                this.$http.get(this.importUrl)
                .then( ({data}) => this.files = data, // Success
                    //Fail
                (response) => {
                    this.alert.type="danger";
                    this.alert.visible=true;
                    this.alert.message="Something went wrong fetching files...";
                });
            },
            deleteFile(file, key) {
                this.$http.delete(this.importUrl+"/"+file.id)
                .then((response) => this.files.splice(key, 1), // Success, remove file from array.
                    (response) => {// Fail
                        this.alert.type="danger";
                        this.alert.visible=true;
                        this.alert.message=response.body.messages;
                    }
                );
            },
            toggleEvent(fileId) {
                window.eventHub.$emit('showDetails', fileId)
            },
            updateAlert(alert) {
                this.alert = alert;
            },
            updateImportErrors(errors) {
                this.importErrors = errors;
            }
        },

        computed: {
            progressWidth() {
                return "width: "+this.progress.currentPercent*10+'%';
            }
        },

        components: {
            alert: require('../alert.vue'),
            errors: require('./importer-errors.vue'),
            importFile: require('./importer-file.vue'),
        }
    }

</script>
