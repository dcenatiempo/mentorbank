const currentAccountDefault = {
    accountHolder: {
        accountHolderId: null,
        name: '',
        birthDate: ''
    },
    accountId: null,
    view: '',
    interestRate: null,
    notifications: false,
    goalBalance: null,
    lowBalanceAlert: null
};

const state = {
    loading: false,
    accountList: [],
    currentAccount: currentAccountDefault
};


const getters = {
};

// direct mutations
// store.commit('mutationName', payload)
const mutations = {
    setAccounts(state, payload) {
        state.accountList = payload;
    },
    setAccountsLoading (state, payload) {
        state.loading = payload;
    },
    addAccount(state, payload) {
        state.accountList = state.accountList.concat(payload);
    },
    setCurrentById(state, id) {
         let account = state.accountList.find( item => item.id == id);
         state.currentAccount = account ? account : currentAccountDefault;
    },
    setCurrentByObj(state, payload) {
        state.currentAccount = payload;
    }
};

// async mutations
// store.dispatch('actionName', payload)
const actions = {
    fetchAllBankAccounts(context) {
        context.commit('setAccountsLoading', true);
        axios.get('/api/account')
        .then((response) => {
            context.commit('setAccounts', response.data)
            context.commit('setAccountsLoading', false);
        })
        .catch((error) => {
            console.log(error);
        });
    },
    createAccount(context, payload) {
        return new Promise((resolve, reject) => {
            context.commit('setAccountsLoading', true);
            axios.post('/api/account', payload)
            .then((response) => {
                context.commit('addAccount', response.data);
                context.commit('setAccountsLoading', false);
                resolve();
            })
            .catch((error) => {
                reject(error);
            });
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