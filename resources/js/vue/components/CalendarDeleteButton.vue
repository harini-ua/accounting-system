<template>
    <div class="invoice-action-btn">
        <span class="btn-block btn waves-effect waves-light" @click="onClick">
            <i class="material-icons">delete</i>
            <span>{{ title }}</span>
        </span>
    </div>
</template>

<script>
import { destroy, showError } from "../mixins";

export default {
    props: ['title', 'url', 'defaultUrl'],
    mixins: [ destroy, showError ],
    methods: {
        onClick: function() {
            this.destroy(this.url, () => window.location.href = this.defaultUrl)
        }
    }
}
</script>

<style scoped>

</style>
