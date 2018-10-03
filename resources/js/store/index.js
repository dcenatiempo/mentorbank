import Vue from 'vue';
import Vuex from 'vuex';
import accounts from './modules/accounts';
import app from './modules/app';
import bank from './modules/bank';
import categories from './modules/categories';
import user from './modules/user';

Vue.use(Vuex);

export default new Vuex.Store({
    modules: {
        accounts,
        app,
        bank,
        categories,
        user,
    }
});