import {toSpinalCase} from '../../helpers.js';

const state = {
    loading: false,
    categoryList: [],
    currentSubscribedCats: []
};

const getters = {
    getCategoryNames: state => state.categoryList.map( item => item.name ),
};

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
    updateCategory(state, updatedCat) {
        state.categoryList = state.categoryList.map(cat => cat.id == updatedCat.id ? updatedCat : cat);
    },
    deleteCategory(state, id) {
        let newCatList = [...state.categoryList];
        let i = newCatList.findIndex(cat=> cat.id == id);
        newCatList.splice(i, 1);
        state.categoryList = newCatList;
    },
    setCurrentSubscribedCats(state, payload) {
        state.currentSubscribedCats = payload;
    }
};

const actions = {
    fetchAllCategories(context) {
        context.commit('setCategoryLoading', true);

        axios.get('/api/bank/category')
            .then( response => {
                context.commit('setCategories', response.data.data)
                context.commit('setCategoryLoading', false);
                return Promise.resolve();
            })
            .catch( error => {
                console.log(error);
                context.commit('setCategoryLoading', false);
                return Promise.reject();
            });
    },
    // fetchAccountSubscribedCats(context, id) {
    //     return new Promise( (resolve, reject) => {
    //         context.commit('setCategoryLoading', true);
    //         axios.get(`/api/account/${id}/subscribed-category`)
    //         .then( response => {
    //             context.commit('setCurrentSubscribedCats', response.data.data);
    //             context.commit('setCategoryLoading', false);
    //             resolve();
    //         }).catch( err => {
    //             reject(err);
    //         })
    //     });
    // },
    fetchBankSubscribedCats(context, subscribedIds) {
        context.commit('setCategoryLoading', true);

        axios.get(`/api/bank/subscribed-category`)
            .then( response => {
                context.commit('accounts/setSubscribedCats', response.data, {root: true});
                context.commit('setCategoryLoading', false);
                return Promise.resolve();
            }).catch( err => {
                context.commit('setCategoryLoading', false);
                return Promise.reject(err);
            });
    },
    createCategory(context, {name, forceSubscribe, subscribedIds}) {
        let payload = toSpinalCase({name, forceSubscribe, subscribedIds});
        context.commit('setCategoryLoading', true);

        axios.post(`/api/bank/category`, payload)
            .then( response => {
                
                // append new category to vuex state
                context.commit('addCategory', response.data.data);
                
                // fetch updated subscribed categories
                if (subscribedIds && subscribedIds.length > 0)
                    context.dispatch('fetchBankSubscribedCats', subscribedIds);

                context.commit('setCategoryLoading', false);
                return Promise.resolve();
            }).catch( err => {
                console.error(err);
                context.commit('setCategoryLoading', false);
                return Promise.reject();
            });
    },
    updateCategory(context, {id, name, forceSubscribe, subscribedIds}) {
        let payload = toSpinalCase({name, forceSubscribe, subscribedIds});
        context.commit('setCategoryLoading', true);

        axios.put(`/api/bank/category/${id}`, payload)
            .then( response => {
                
                // append new category to vuex state
                context.commit('updateCategory', response.data.data);
                
                // fetch updated subscribed categories
                context.dispatch('fetchBankSubscribedCats', subscribedIds);

                // fetch updated transactions
                context.dispatch('transactions/fetchAllTransactions', null, {root: true} );

                context.commit('setCategoryLoading', false);
                return Promise.resolve();
            }).catch( err => {
                console.error(err);
                context.commit('setCategoryLoading', false);
                return Promise.reject();
            });
    },
    deleteCategory(context, id) {
        context.commit('setCategoryLoading', true);

        axios.delete(`/api/bank/category/${id}`)
            .then( response => {
                context.commit('deleteCategory', id);

                // fetch updated transactions
                if (response.data.refetchTransactions == true)
                    context.dispatch('transactions/fetchAllTransactions', null, {root: true});

                context.commit('setCategoryLoading', false);
                return Promise.resolve();
            }).catch( err => {
                console.error(err);
                context.commit('setCategoryLoading', false);
                return Promise.reject();
            });
    },
    updateSubscribedCategory(context, {accountId, subscribedCategory}) {
        let id = subscribedCategory.id;
        let payload = toSpinalCase(subscribedCategory);
        context.commit('setCategoryLoading', true);

        axios.put(`/api/account/${accountId}/subscribed-category/${id}`, payload)
            .then( response => {
                context.commit('accounts/setSubscribedCat', response.data.data, {root: true});
                context.commit('setCategoryLoading', false);
                return Promise.resolve();
            }).catch( err => {
                console.error(err);
                context.commit('setCategoryLoading', false);
                return Promise.reject();
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