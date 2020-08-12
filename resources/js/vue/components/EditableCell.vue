<template>
    <div class="editable-cell" @click="editMode">
        <span v-if="!isEdit">
            {{ value }}
        </span>
        <input
            v-if="isEdit"
            :ref="'input'"
            v-bind:value="value"
            @keyup.enter="save"
            @blur="save"
        >
    </div>
</template>

<script>
export default {
    props: ['value'],
    data() {
        return {
            isEdit: false
        }
    },
    methods: {
        editMode: function() {
            this.isEdit = true;
            this.$nextTick(() => {
                this.$refs.input.focus();
            });
        },
        save: function(event) {
            if (this.isEdit) {
                this.isEdit = false;
                this.$emit('update', event.target.value);
            }
        }
    }
}
</script>

<style>
    .editable-cell input {
        max-width: fit-content;
    }
</style>
