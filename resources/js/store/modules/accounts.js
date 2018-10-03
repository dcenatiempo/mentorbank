const state = {
    loading: false,
    accountList: [],
    currentAccount: {
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
    }
};


const getters = {
};

// direct mutations
// store.commit('mutationName', payload)
const mutations = {
};

// async mutations
// store.dispatch('actionName', payload)
const actions = {
};

export default {
    namespaced: true,
    state,
    getters,
    mutations,
    actions,
};