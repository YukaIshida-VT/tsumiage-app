const state = {
    userAgent: false,
};

const getters = {
    userAgent: state => {
        return state.userAgent;
    }
};

const actions = {
    getUserAgent({commit}) {
        axios.post('/api/get-ua')
            .then(res => {
                commit('setUserAgent', res.data);
            })
            .catch(error => {
                console.log('Unable to detect userAgent');
            });
    }
};

const mutations = {
    setUserAgent(state, userAgent) {
        state.userAgent = userAgent;
    }
};

export default {
    state, getters, actions, mutations,
}
