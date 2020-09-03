<template>
    <div>
        <h6 class="center-align">Add Vacation</h6>
        <div class="add-vacation btn-group">
            <button type="button" :class="buttonClass('planned')" @click="onClick('planned')">Planned</button>
            <button type="button" :class="buttonClass('actual')" @click="onClick('actual')">Actual</button>
            <button type="button" :class="buttonClass('sick')" @click="onClick('sick')">Sick</button>
            <button type="button" :class="buttonClass('weekday')" @click="onClick('weekday')">Clear</button>
        </div>
    </div>
</template>

<script>
import {mapGetters, mapMutations} from 'vuex';
export default {
    name: "AddVacation",
    data() {
        return {
            colors: {
                planned: 'yellow',
                actual: 'green',
                sick: 'blue',
                weekday: 'btn-light-cyan',
            }
        }
    },
    methods: {
        ...mapMutations([
            'setFillType'
        ]),
        buttonClass(type) {
            return {
                btn: true,
                [this.colors[type]]: true,
                active: type === this.fillType
            }
        },
        onClick(type) {
            this.setFillType({
                fillType: this.fillType !== type ? type : ''
            });
        }
    },
    computed: {
        ...mapGetters({
            fillType: 'getFillType'
        })
    }
}
</script>

<style scoped>
    .add-vacation .active {
        border: 1px solid #0c0c0c !important;
    }
</style>
