import Vue from 'vue';
import store from "./store";
import CalendarTable from "./components/CalendarTable";
import Holidays from "./components/Holidays";

new Vue({
    el: '#vue-app',
    store: store,
    components: {
        CalendarTable,
        Holidays
    }
});
