import Vue from 'vue';
import store from "./store";
import CalendarTable from "./components/CalendarTable";

new Vue({
    el: '#vue-app',
    store: store,
    components: {
        CalendarTable
    }
});
