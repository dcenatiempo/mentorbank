const state = {
    loading: false,
    vpWidth: window.innerWidth,
    vpHeight: window.innerHeight,
    showModals: {},
    modalPayload: {},
    pageHistory: ['bank|dashboard']
};


const getters = {
    currentPage: state => state.pageHistory[state.pageHistory.length-1]
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
    pushPageHistory(state, page) {
        let newHistory = [...state.pageHistory];
        newHistory.push(page);
        state.pageHistory = newHistory;
    },
    popPageHistory(state) {
        if (state.pageHistory.length === 1 ) return;
        let newHistory = [...state.pageHistory];
        newHistory.pop();
        state.pageHistory = newHistory;
    },
    resetHistory(state) {
        state.pageHistory = [state.pageHistory[0]];
    },
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