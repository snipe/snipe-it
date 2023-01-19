
<style scoped>
</style>

<template>
        <div class="col-md-12" :class="alertType">
            <div class="alert" :class="alertClassName">
                <button type="button" class="close" @click="hideEvent">&times;</button>
                <i class="fas fa-check faa-pulse animated" aria-hidden="true" v-show="alertType == 'success'"></i>
                <strong>{{ title }} </strong>
                <slot></slot>
            </div>
        </div>
</template>

<script>
    export default {
        /*
         * The component's data.
         */
        props: ['alertType', 'title'],

        computed: {
            alertClassName() {
                return 'alert-' + this.alertType;
            }
        },

        methods: {
            hideEvent() {
                this.$emit('hide');
            }
        }
    }

</script>
