import Vue from 'vue';
import Vuex from "vuex";

Vue.use(Vuex);

export default new Vuex.Store({
    state: window.preState,
    getters: {
        quarterMonths: state => quarter => state.months.filter(month => month.quarter === quarter),
        halfYearMonths: state => halfYear => state.months.filter(month => month.halfYear === halfYear),
        allMonths: state => state.months,
    },
    mutations: {
        setMonthField (state, payload) {
            state.months.filter(month => month.id === payload.monthId)[0][payload.field] = payload.value;
        }
    }
});
