import axios from "axios";

export default {
    state: () => ({
        vacations: [],
        totalVacations: 0,
        fillType: ''
    }),
    getters: {
        allVacations: state => state.vacations,
        totalVacations: state => state.totalVacations,
        getFillType: state => state.fillType
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
        }
    },
    actions: {
        fetchVacations({ commit, state }, payload) {
            axios({
                method: 'GET',
                url: `/vacations/${payload.year}/${payload.month}`,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                },
                params: payload.params
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
