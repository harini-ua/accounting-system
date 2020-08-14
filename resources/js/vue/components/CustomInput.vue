<template>
    <div>
        <span v-if="!isEdit">
            {{ value }}
        </span>
        <input
            v-show="isEdit"
            v-bind:value="value"
            v-on:input="$emit('input', $event.target.value)"
        >
    </div>
</template>

<script>
export default {
    props: ['value', 'isEdit'],
}
</script>

<style scoped>

</style>
