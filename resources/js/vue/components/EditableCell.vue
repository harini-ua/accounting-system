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

<style scoped lang="scss">
    .editable-cell  {
        position: relative;
        input {
            max-width: fit-content;
            border: none !important;
            margin: 0;
            font-size: 14px;
            font-weight: 400;
            height: auto;
            position: relative;
        }
    }
    .editable-cell i {
        display: none;
        position: absolute;
        left: -3px;
    }
    .editable-cell:hover i {
        display: inline;
        font-size: 0.8rem;
        top: 50%;
        transform: translateY(-50%);
    }
</style>
