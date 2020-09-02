import axios from "axios";

export default {
    state: () => ({
        vacations: [],
        totalVacations: 0,
    }),
    getters: {
        allVacations: state => state.vacations,
        totalVacations: state => state.totalVacations
    },
    mutations: {
        setVacations (state, payload) {
            state.vacations = payload.vacations;
            state.totalVacations = payload.totalVacations;
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
                .catch(error => console.log(error))
        }
    }
}
