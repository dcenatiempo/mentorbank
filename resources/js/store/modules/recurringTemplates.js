const state = {
    loading: false,
    templateList: [],
    currentTemplate: {
        templateId: null,
        startDate: null,
        frequency: '',
        memo: '',
        type: '',
        split: [],
        netAmount: [],
        accountId: null
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