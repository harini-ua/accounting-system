import Vue from 'vue';
import VacationMonthTable from "./components/VacationMonthTable";
import store from "./store";

new Vue({
    el: '#vue-app',
    store: store,
    components: {
        VacationMonthTable
    }
});
