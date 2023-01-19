

<script>
    require('blueimp-file-upload');
    var baseUrl = $('meta[name="baseUrl"]').attr('content');
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
                importErrors: null,
                progress: {
                    currentClass: "progress-bar-warning",
                    currentPercent: "0",
                    statusText: '',
                    visible: false
                },
                customFields: [],
            };
        },

        mounted() {
            window.eventHub.$on('importErrors', this.updateImportErrors);
            this.fetchFiles();
            this.fetchCustomFields();
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
                this.$http.get(baseUrl + 'api/v1/imports')
                .then( ({data}) => this.files = data, // Success
                    //Fail
                (response) => {
                    this.alert.type="danger";
                    this.alert.visible=true;
                    this.alert.message="Something went wrong fetching files...";
                });
            },
            fetchCustomFields() {
                this.$http.get(baseUrl + 'api/v1/fields')
                .then( ({data}) => {
                    data = data.rows;
                    data.forEach((item) => {
                        this.customFields.push({
                            'id': item.db_column_name,
                            'text': item.name,
                        })
                    })
                });
            },
            deleteFile(file, key) {
                this.$http.delete(baseUrl + 'api/v1/imports/' + file.id)
                .then(
                    // Success, remove file from array.
                    (response) => {
                        this.files.splice(key, 1);
                        this.alert.type = response.body.status; // A failed delete can still cause a 200 status code.
                        this.alert.visible = true;
                        this.alert.message = response.body.messages;
                    },
                    (response) => {// Fail
                        // this.files.splice(key, 1);
                        this.alert.type="error";
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
            },
        },

        computed: {
            progressWidth() {
                return "width: "+this.progress.currentPercent*10+'%';
            }
        },

        components: {
            alert: require('../alert.vue').default,
            errors: require('./importer-errors.vue').default,
            importFile: require('./importer-file.vue').default,
        }
    }

</script>
