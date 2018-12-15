import {toSpinalCase} from '../../helpers.js';

const state = {
    loading: false,
    hasBeenLoaded: false,
    transactionList: []
};

const getters = {
};

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

const actions = {
    fetchAllTransactions(context, payload) {
        context.commit('setHasBeenLoaded', true);
        context.commit('setTransactionLoading', true);
        axios.get('/api/bank/transaction')
        .then( response => {
            context.commit('setTransactions', response.data.data)
            context.commit('setTransactionLoading', false);
        }).catch( err => {
            console.error(err);
            context.commit('setTransactionLoading', false);
            return Promise.reject(err);
        });
    },
    saveTransaction(context, transaction) {
        let payload = toSpinalCase(transaction);
        context.commit('setTransactionLoading', true);

        axios.post(`/api/account/${transaction.accountId}/transaction`, payload)
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
                return Promise.resolve();
            }).catch( err => {
                console.error(err);
                context.commit('setTransactionLoading', false);
                return Promise.reject(err);
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