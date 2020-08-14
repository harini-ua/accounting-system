<template>
    <div>
        <span v-if="!isEdit">
            {{ value }}
        </span>
        <input
            v-show="isEdit"
            v-bind:value="value"
            v-on:change="$emit('input', $event.target.value)"
            class="datepicker"
        >
    </div>
</template>

<script>
export default {
    props: ['value', 'isEdit'],
    mounted() {
        M.Datepicker.init(this.$el.querySelector('input'), {
            autoClose: true,
            format: 'dd-mm-yyyy',
            container: 'body',
            defaultDate: Date.parse(this.value).toString(),
            setDefaultDate: true,
            showClearBtn: true
        });
    }
}
</script>

<style scoped>

</style>
