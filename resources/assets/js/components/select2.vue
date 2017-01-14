
<style scoped>
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
            console.dir(this.options);
            var vm = this;
            $(this.$el)
                .select2({ 
                    data: [
                    {id: 0, text: 'test'},
                    {id: 1, text: 'test2'}
                ]
                });
        },
        watch: {
            value() {
                $(this.$el).val(value)
            },
            options: (options) => {
                $(this.$el).select2({data: options})
            },
            destroyed() {
                $(this.$el).off().select2('destroy')
            }
        }
    }

</script>
