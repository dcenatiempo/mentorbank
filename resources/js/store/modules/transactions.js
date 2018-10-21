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
    fetchAllTransactions(context) {
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
    saveTransaction(context, transaction) {
        return new Promise( (resolve, reject) => {
            context.commit('setTransactionLoading', true);
            axios.post(`/api/account/${transaction.accountId}/transaction`, transaction)
            .then( result => {
                context.commit('addTransaction', result.data);
                context.commit('setTransactionLoading', false);
                resolve();
            }).catch( err => {
                console.error(err);
                reject(err);
            })
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