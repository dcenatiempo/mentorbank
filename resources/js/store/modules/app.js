const state = {
    loading: false,
    vpWidth: window.innerWidth,
    vpHeight: window.innerHeight,
    showModals: {},
    modalPayload: {},
    page: {
        // 'dashboard', 'settings', 'profile' 'transactions', 'categories', 'notifications', 'templates'
        bank: 'dashboard', 
        account: 'dashboard',
        breadcrumbs: []
    }
    // modals
};


const getters = {
    bankPage: state => state.page.bank,
    accountPage: state => state.page.account
};

// direct mutations
// store.commit('mutationName', payload)
const mutations = {
    registerModal(state, modalId) {
        state.showModals = Object.assign({}, state.showModals, {[modalId]: false});
    },
    showModal(state, {modalId, payload}) {
        state.showModals = Object.assign({}, state.showModals, {[modalId]: true});
        state.modalPayload = Object.assign({}, state.modalPayload, {[modalId]: payload});
    },
    hideModal(state, modalId) {
        state.showModals = Object.assign({}, state.showModals, {[modalId]: false});
        state.modalPayload = Object.assign({}, state.modalPayload, {[modalId]: null});
    },
    setBankPage(state, page) {
        state.page.bank = page;
    },
    setAccountPage(state, page) {
        state.page.account = page;
    }
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