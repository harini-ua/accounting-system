<template>
    <span class="add-available-total cursor-pointer" title="Add available days" @click="editMode">
        <i class="material-icons tiny">edit</i>
        <input
            v-if="isEdit"
            :ref="'input'"
            v-bind:value="value"
            @keyup.enter="save"
            @blur="save"
        >
    </span>
</template>

<script>
export default {
    name: "AddAvailableTotal",
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

<style scoped>
    .add-available-total input {
        max-width: fit-content;
    }
</style>
