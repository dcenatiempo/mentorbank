const state = {
    loading: true,
    id: null,
    name: '',
    created_at: '',
    updated_at: '',
};


const getters = {
};

// direct mutations
// store.commit('mutationName', payload)
const mutations = {
    setBank (state, payload) {
        state = Object.assign( state, payload, {loading: false} );
    },
    setBankLoading (state, payload) {
        state.loading = payload;
    }
};

// async mutations
// store.dispatch('actionName', payload)
const actions = {
    fetchBank (context) {
        context.commit('setBankLoading', true);
        axios.get('/api/bank')
        .then(function (response) {
            context.commit('setBank', response.data.data)
        })
        .catch(function (error) {
            console.log(error);
        });
    },
    createBank (context, name) {
        return new Promise((resolve, reject) => {
            context.commit('setBankLoading', true);
        
            axios.post('/api/bank', {
                name: name
            })
            .then(function (response) {
                context.commit('setBank', response.data.data)
                resolve();
            })
            .catch(function (error) {
                reject(error);
            });
        })
        
    }
};

export default {
    namespaced: true,
    state,
    getters,
    mutations,
    actions,
};