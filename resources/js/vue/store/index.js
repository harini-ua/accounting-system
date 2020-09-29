import Vue from 'vue';
import Vuex from "vuex";
import calendar from "./calendar";
import vacations from "./vacations";

Vue.use(Vuex);

export default new Vuex.Store({
    modules: {
        calendar: calendar,
        vacations: vacations
    }
});