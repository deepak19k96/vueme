

import axios from 'axios';



const state = {
    loading: false,
    error: '',
    items: [],
    view: [],
    per_page: 12,
    page: 1,
    all: [],
    colors: ['orange', '#9c27b0', 'pink', '#90CAF9', 'orangered', 'green']
};

function error(error) {
    return {type: 'error', error};
}

function loading(loading) {
    return {type: 'loading', loading};
}

function success(items) {
    return {type: 'list', items};
}

function view(items) {
    return { type: 'view', items};
}

function page(page) {
    return { type: 'page', page};
}

function per_page(per_page) {
    return { type: 'per_page', per_page};
}
function all(items) {
    return {type: 'all', items};
}
const getters = {
    error: state => state.error,
    items: state => state.items,
    loading: state => state.loading,
    view: state => state.view,
    per_page: state => state.per_page,
    page: state => state.page,
    all: state => state.all,
    colors: state => state.colors
};

const actions = {
    getItems({ commit, rootState }, params) {

        commit(loading(true));
        return axios.get(rootState.util.entrypoint + '/api/v1/search/psychics?page=' + state.page + '&per_page=' + state.per_page + '&cat=' + params.cat + '&filters=' + JSON.stringify(params.filters))
            .then(response => {
                commit(loading(false));
                commit(success(response.data));
                return true
            })
            .catch(e => {
                commit(loading(false));
                commit(error(e.messages));
            });
    },
    getAll({ commit, rootState }) {
        commit(loading(true));
        return axios.get(rootState.util.entrypoint + '/api/v1/search/psychics')
            .then(response => {
                commit(loading(false));
                commit(all(response.data.data));
                return true
            })
            .catch(e => {
                commit(loading(false));
                commit(error(e.messages));
            });
    },
    getItem({ commit, rootState }, param) {
        
        let endpoint = '/api/v1/search/psychic/profile/'+param;
        if(typeof param == "object")
         endpoint = '/api/v1/search/psychic/profile/'+param.user + '?offset=' + param.offset + '&client=' + param.client;

        commit(loading(true));
        return axios.get(rootState.util.entrypoint + endpoint)
            .then(response => {
                commit(loading(false));
                commit(view(response.data));
                return true
            })
            .catch(e => {
                commit(loading(false));
                commit(error(e.messages));
            });
    },
    store({ commit }, values) {
        commit(loading(true));
        return axios.post( endpoint, values).then((response) => {
            commit(loading(false));
            return response;
        }).catch(e => {
            commit(loading(false));
            commit(error(e.messages));
        });
    },
    update({ commit }, values) {
        commit(loading(true));
        return axios.put( endpoint + '/' + values.id, values).then((response) => {
            commit(loading(false));
            return response;
        }).catch(e => {
            commit(loading(false));
            commit(error(e.messages));
        });
    },
    delete({ commit }, id) {
        commit(loading(true));
        return axios.delete( endpoint + '/' + id).then((response) => {
            commit(loading(false));
            return response;
        }).catch(e => {
            commit(loading(false));
            commit(error(e.messages));
        });
    },
    page({ commit }, val = false) {
        commit(page(val || state.page + 1));
    },
    perPage({ commit }, val) {
        commit(per_page(val));
    },
};

const mutations = {
    error(state, payload) {
        state.error = payload.error;
    },
    loading(state, payload) {
        state.loading = payload.loading;
    },
    view(state, payload) {
        state.view = payload.items;
    },
    list(state, payload) {
        state.items = payload.items;
    },
    page(state, payload) {
        state.page = payload.page;
    },
    per_page(state, payload) {
        state.per_page = payload.per_page;
    },
    all(state, payload) {
        state.all = payload.items;
    }
};

export default {
    namespaced: 'index',
    state,
    getters,
    actions,
    mutations
}
