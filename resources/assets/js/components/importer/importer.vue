

<script>
    require('blueimp-file-upload'); //FIXME - how do I get this out? Wait, I think it's already there!
    export default {
        /*
         * The component's data.
         */
        data() {
            return {
                alert: {
                    type: null,
                    message: null,
                    visible: false,
                },
                importErrors: null,
            };
        },

        mounted() {
            window.eventHub.$on('importErrors', this.updateImportErrors);
        },

        methods: {
            deleteFile(file, key) {
                this.$http.delete(route('api.imports.destroy', file.id))
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
    }

</script>
