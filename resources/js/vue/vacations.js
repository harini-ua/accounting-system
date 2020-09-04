import Vue from 'vue';
import store from "./store";
import VacationMonthTable from "./components/VacationMonthTable";
import AddVacation from "./components/AddVacation";
import ShowAllVacations from "./components/ShowAllVacations";

new Vue({
    el: '#vue-app',
    store: store,
    components: {
        VacationMonthTable,
        AddVacation,
        ShowAllVacations
    }
});
