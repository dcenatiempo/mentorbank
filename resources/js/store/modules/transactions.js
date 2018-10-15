const state = {
    loading: false,
    transactionList: []
};


const getters = {
};

// direct mutations
// store.commit('mutationName', payload)
const mutations = {
    setTransactions(state, payload) {
        state.transactionList = payload;
    },
    setTransactionLoading (state, payload) {
        state.loading = payload;
    },
    addTransaction(state, payload) {
        state.transactionList = state.transactionList.concat(payload);
    }
};

// async mutations
// store.dispatch('actionName', payload)
const actions = {
    getAllTransactions(context) {
        context.commit('setTransactionLoading', true);
        axios.get('/api/bank/transaction')
        .then(function (response) {
            context.commit('setTransactions', response.data)
            context.commit('setTransactionLoading', false);
        })
        .catch(function (error) {
            console.log(error);
        });
    },
};

export default {
    namespaced: true,
    state,
    getters,
    mutations,
    actions,
};