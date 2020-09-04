import axios from "axios";

export default {
    state: () => window.preState || {
        months: [],
        fetchMonths: '',
    },
    getters: {
        quarterMonths: state => quarter => state.months.filter(month => month.quarter === quarter),
        halfYearMonths: state => halfYear => state.months.filter(month => month.halfYear === halfYear),
        allMonths: state => state.months,
    },
    mutations: {
        setMonthField (state, payload) {
            state.months.filter(month => month.id === payload.monthId)[0][payload.field] = payload.value;
        },
        setMonths (state, payload) {
            state.months = payload.months;
        }
    },
    actions: {
        fetchMonths({ commit, state }) {
            axios.get(state.fetchMonths).then(resp => commit('setMonths', { months: resp.data }));
        }
    }
};
