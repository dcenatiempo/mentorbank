const state = {
    loading: false,
    categoryList: []
};


const getters = {
};

// direct mutations
// store.commit('mutationName', payload)
const mutations = {
    setCategories(state, payload) {
        state.categoryList = payload;
    },
    setCategoryLoading (state, payload) {
        state.loading = payload;
    },
    addCategory(state, payload) {
        state.categoryList = state.categoryList.concat(payload);
    }
};

// async mutations
// store.dispatch('actionName', payload)
const actions = {
    getAllCategories(context) {
        context.commit('setCategoryLoading', true);
        axios.get('/api/category')
        .then(function (response) {
            context.commit('setCategories', response.data)
            context.commit('setCategoryLoading', false);
        })
        .catch(function (error) {
            console.log(error);
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