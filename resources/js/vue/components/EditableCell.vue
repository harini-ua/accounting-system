<template>
    <div class="editable-cell cursor-pointer" @click="editMode">
        <span v-if="!isEdit">
            <i class="material-icons tiny">edit</i>
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

<style scoped>
    .editable-cell input {
        max-width: fit-content;
    }
</style>
