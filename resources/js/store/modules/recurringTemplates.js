import {toSpinalCase} from '../../helpers.js';

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

const mutations = {
};

const actions = {
};

export default {
    namespaced: true,
    state,
    getters,
    mutations,
    actions,
};