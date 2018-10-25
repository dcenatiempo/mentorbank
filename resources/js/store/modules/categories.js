const state = {
    loading: false,
    categoryList: [],
    currentSubscribedCats: []
};


const getters = {
    getCategoryNames: state => state.categoryList.map( item => item.name ),
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
    },
    setCurrentSubscribedCats(state, payload) {
        state.currentSubscribedCats = payload;
    }
};

// async mutations
// store.dispatch('actionName', payload)
const actions = {
    fetchAllCategories(context) {
        context.commit('setCategoryLoading', true);
        axios.get('/api/bank/category')
        .then( response => {
            context.commit('setCategories', response.data)
            context.commit('setCategoryLoading', false);
        })
        .catch( error => {
            console.log(error);
            context.commit('setCategoryLoading', false);
        });
    },
    fetchSubscribedCats(context, id) {
        return new Promise( (resolve, reject) => {
            context.commit('setCategoryLoading', true);
            axios.get(`/api/account/${id}/subscribed-category`)
            .then( res => {
                context.commit('setCurrentSubscribedCats', res.data);
                context.commit('setCategoryLoading', false);
                resolve();
            }).catch( err => {
                reject(err);
            })
        });
    },
    createCategory(context, {name, forceSubscribe, subscribedIds}) {
        return new Promise( (resolve, reject) => {
            context.commit('setCategoryLoading', true);
            axios.post(`/api/bank/category`, {
                name,
                forceSubscribe,
                'subscribed': subscribedIds
            }).then( response => {
                context.commit('addCategory', response.data);
                context.commit('setCategoryLoading', false);
                resolve();
            }).catch( err => {
                console.error(err);
                context.commit('setCategoryLoading', false);
                reject();
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