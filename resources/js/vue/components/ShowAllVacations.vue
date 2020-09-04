<template>
    <div class="checkbox-filter display-flex align-items-center flex-grow-1 ml-5">
        <label>
            <input v-model="value" type="checkbox"/>
            <span>Show All</span>
        </label>
    </div>
</template>

<script>
import {mapActions, mapMutations} from 'vuex';
export default {
    name: "ShowAllVacations",
    data() {
        return {
            value: false
        }
    },
    watch: {
        value(value) {
            this.setShowAll(value)
            this.fetchVacations({
                showAll: value
            });
        }
    },
    methods: {
        ...mapActions(['fetchVacations']),
        ...mapMutations(['setShowAll'])
    }
}
</script>

<style scoped>

</style>
