const state = {
    yyyymmdd: null,
    yyyy_mm_dd: null,
    tsumiageCount: null
};

const getters = {
    yyyymmdd: state => {
        return state.yyyymmdd;
    },
    yyyy_mm_dd: state => {
        return state.yyyy_mm_dd;
    },
    tsumiageCount: state => {
        return state.tsumiageCount;
    },
};

const actions = {
    setDay({commit}, payload) {
        commit('setYyyymmdd', payload[0]);
        commit('setYyyy_mm_dd', payload[1]);
    },
    fetchTsumiageCount({commit, state}) {
        axios.post('/api/user-tsumiage', {date: state.yyyy_mm_dd})
            .then(res => {
                commit('setTsumiageCount', res.data.count);
            })
            .catch(error => {
                console.log('Unable to fetch tsumiage count');
            });
    }
};

const mutations = {
    setYyyymmdd(state, yyyymmdd) {
        state.yyyymmdd = yyyymmdd;
    },
    setYyyy_mm_dd(state, yyyy_mm_dd) {
        state.yyyy_mm_dd = yyyy_mm_dd;
    },
    setTsumiageCount(state, tsumiageCount) {
        state.tsumiageCount = tsumiageCount;
    },
    // updateYyyymmdd(state, yyyymmdd) {
    //     state.yyyymmdd = yyyymmdd;
    // },
    updateTsumiageCount(state, tsumiageCount) {
        state.yyyymmdd = tsumiageCount;
    },
};

export default {
    state, getters, actions, mutations,
}