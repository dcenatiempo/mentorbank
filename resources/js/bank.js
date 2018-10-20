require('./bootstrap');

import GlobalMixin from './GlobalMixin';
import {mapState, mapGetters, mapActions, mapMutations} from 'vuex';

import VueRouter from 'vue-router';
Vue.use(VueRouter)
import BankDashboard from './components/bank/BankDashboard.vue';
import Profile from'./components/bank/Profile.vue';
import Settings from'./components/bank/Settings.vue';
import Categories from './components/bank/Categories.vue';
import Transactions from './components/bank/Transactions.vue';
import Accounts from './components/bank/Accounts.vue';

const router = new VueRouter({
    mode: 'history',
    routes: [
        {
            path: '/bank',
            name: 'dashboard',
            component: BankDashboard
        },{
            path: '/bank/accounts',
            name: 'accounts',
            component: Accounts
        },{
            path: '/bank/transactions',
            name: 'transactions',
            component: Transactions
        },{
            path: '/bank/categories',
            name: 'categories',
            component: Categories
        },{
            path: '/bank/profile',
            name: 'profile',
            component: Profile
        },{
            path: '/bank/settings',
            name: 'Settings',
            component: Settings
        }
    ]
});

Vue.component('category-modal', require('@modals/CategoryModal.vue'));
Vue.component('transaction-modal', require('@modals/TransactionModal.vue'));
Vue.component('account-modal', require('@modals/AccountModal.vue'));
Vue.component('add-transaction-btn', require('@reusable/AddTransactionBtn.vue'));

const app = new Vue({
    el: '#bank',
    router: router,
    mixins  : [ GlobalMixin ],
    computed: {
        ...mapState('user',['type', 'loading']),
        ...mapState(['accounts']),
    },
    methods: {
        ...mapActions('accounts', ['getAllBankAccounts']),
        ...mapActions('bank', ['getBank']),
    },
    created() {
        this.getBank();
        this.getAllBankAccounts();
    },

});
