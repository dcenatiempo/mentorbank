const state = {
    loading: false,
    hasBeenLoaded: false,
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
    setHasBeenLoaded (state, payload) {
        state.hasBeenLoaded = payload;
    },
    addTransaction(state, payload) {
        state.transactionList = [payload].concat(state.transactionList);
    }
};

// async mutations
// store.dispatch('actionName', payload)
const actions = {
    fetchAllTransactions(context, payload) {
        context.commit('setHasBeenLoaded', true);
        context.commit('setTransactionLoading', true);
        axios.get('/api/bank/transaction')
        .then(function (response) {
            context.commit('setTransactions', response.data.data)
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
                context.commit('addTransaction', result.data.data);
                context.commit('accounts/addTransaction', result.data.data, {root: true});
                context.commit('accounts/changeAccountBalance', 
                    {
                        accountId: result.data.data.accountId,
                        type: result.data.data.type,
                        amount: result.data.data.netAmount
                    },
                    {root: true});
                context.commit('accounts/changeAccountCategoryBalance', 
                    {
                        accountId: result.data.data.accountId,
                        type: result.data.data.type,
                        split: result.data.data.split
                    },
                    {root: true});
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