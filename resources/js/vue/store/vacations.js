import axios from "axios";

export default {
    state: () => ({
        vacations: [],
        totalVacations: 0,
        fillType: '',
        page: 1,
        length: 20,
        year: '',
        month: '',
        showAll: false,
    }),
    getters: {
        allVacations: state => state.vacations,
        totalVacations: state => state.totalVacations,
        getFillType: state => state.fillType,
        getPage: state => state.page,
        getLength: state => state.length,
        getYear: state => state.year,
        getMonth: state => state.month,
        getShowAll: state => state.showAll,
    },
    mutations: {
        setVacations (state, payload) {
            state.vacations = payload.vacations;
            state.totalVacations = payload.totalVacations;
        },
        setVacationType (state, payload) {
            const index = state.vacations.findIndex(
                vacation => vacation.id === payload.item.id && vacation.payment === payload.item.payment
            );
            state.vacations[index][payload.day.day] = state.fillType;
        },
        setFillType: (state, payload) => state.fillType = payload.fillType,
        setAvailableVacations: (state, payload) => {
            const index = state.vacations.findIndex(vacation => vacation.id === payload.item.id);
            state.vacations[index].available_vacations = parseFloat(state.vacations[index].available_vacations) + parseInt(payload.available_vacations, 10);
        },
        setPage: (state, payload) => state.page = payload,
        setYear: (state, payload) => state.year = payload,
        setMonth: (state, payload) => state.month = payload,
        setShowAll: (state, payload) => state.showAll = payload,
    },
    actions: {
        fetchVacations({ commit, state }, payload = {}) {
            const params = {
                draw: state.page,
                start: state.length*(state.page-1),
                length: state.length,
            }
            if (state.showAll) {
                params.show_all = 1;
            }
            axios({
                method: 'GET',
                url: `/vacations/${state.year}/${state.month}`,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                },
                params: params
            })
                .then(resp => {
                    commit('setVacations', {
                        vacations: resp.data.data,
                        totalVacations: resp.data.recordsTotal,
                    });
                })
        },
        setVacation({ commit, state }, payload) {
            axios.post('/vacations', {
                person_id: payload.item.id,
                type: state.fillType,
                payment_type: payload.item.payment,
                date: payload.day.date
            })
                .then(() => commit('setVacationType', payload))
        },
        deleteVacation({ commit, state }, payload) {
            axios.post(`/vacations/delete`, {
                person_id: payload.item.id,
                payment_type: payload.item.payment,
                date: payload.day.date
            })
                .then(() => commit('setVacationType', payload))

        },
        setAvailableVacations({ commit, state }, payload) {
            axios.patch(`/people/available-vacations/${payload.item.id}`, {
                available_vacations: payload.available_vacations
            })
                .then(() => commit('setAvailableVacations', payload))
        }
    }
}
