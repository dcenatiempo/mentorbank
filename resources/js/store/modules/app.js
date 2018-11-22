const state = {
    loading: false,
    vpWidth: window.innerWidth,
    vpHeight: window.innerHeight,
    showModals: {},
    modalPayload: {},
    isTouchDevice: false,
    isLoggedIn: false
};


const getters = {
    showOverlay(state) {
        let show = false;
        for (let modal in state.showModals) {
            show = state.showModals[modal] ? true : show;
        }
        return show;
    }
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
    setSize(state, {width, height}) {
        state.vpWidth = width;
        state.vpHeight = height;
    },
    setTouchDevice(state) {
        state.isTouchDevice = true;
    },
    setIsLoggedIn(state, payload) {
        state.isLoggedIn = payload
    }

};

// async mutations
// store.dispatch('actionName', payload)
const actions = {};

export default {
    namespaced: true,
    state,
    getters,
    mutations,
    actions,
};