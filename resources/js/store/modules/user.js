import {toSpinalCase} from '../../helpers.js';

const state = {
    loading: true,
    id: null,
    type: '', // none, banker, accountHolder
    name: '',
    email: '',
    pin: '',
    // birthdate: null,
    createdAt: {date: null},
};


const getters = {
    firstName: state => state.name.split(' ')[0],
    lastName: state => state.name.split(' ')[1] ? state.name.split(' ')[1] : '',
    memberSince: state => moment.utc(state.createdAt.date).fromNow()
};

const mutations = {
    setUser (state, payload) {
        state = Object.assign( state, payload, {loading: false} );
    },
    setUserLoading (state, payload) {
        state.loading = payload;
    },
    setType (state, payload) {
        state.type = payload;
    },
};

const actions = {
    fetchUser (context, payload) {
        context.commit('setUserLoading',true);
        axios.get('/api/user')
            .then(function (response) {
                context.commit('setUserLoading',false);
                context.commit('setUser', response.data.data);
                return Promise.resolve();
            })
            .catch(function (error) {
                console.log(error);
                return Promise.reject();
            });
    },
    updateUser (context, payload) {
        context.commit('setUserLoading',true);
        axios.patch('/api/user', payload)
            .then(function (response) {
                context.commit('setUserLoading',false);
                context.commit('setUser', response.data.data);
            })
            .catch(function (error) {
                console.log(error);
            });
    }
};

export default {
    namespaced: true,
    state,
    getters,
    mutations,
    actions,
};