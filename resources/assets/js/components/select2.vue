
<style scoped>
    .select2-dropdown {
        z-index:9999;
    }
</style>

<template>
        <select style="width:100%">
            <slot></slot>
        </select>
</template>

<script>
    require('select2');
    export default {
        /*
         * The component's data.
         */
        props: ['options', 'value'],

        mounted() {
            var vm = this;
            $(this.$el)
                .select2({
                    data: this.options
                })
                .on('change', function() { vm.$emit('input', this.value) } )
                .val(this.value).trigger('change');
        },
        watch: {
            value: function (value) {
                $(this.$el).val(value)
            },
            options: function (options) {
                $(this.$el).select2({data: options})
            },
            destroyed: function() {
                $(this.$el).off().select2('destroy')
            }
        }
    }

</script>
