require('./bootstrap');

import GlobalMixin from './GlobalMixin';
import {mapState, mapGetters, mapActions, mapMutations} from 'vuex';

import VueRouter from 'vue-router';
Vue.use(VueRouter);
import BankPortal from './components/bank/BankPortal.vue';
import BankDashboard from './components/bank/BankDashboard.vue';
import Profile from'./components/bank/Profile.vue';
import Settings from'./components/bank/Settings.vue';
import Categories from './components/bank/Categories.vue';
import Transactions from './components/bank/Transactions.vue';
import Accounts from './components/bank/Accounts.vue';
import AccountDashboard from './components/bank/AccountDashboard.vue';

import DeleteIcon from 'icons/delete';
Vue.component('delete-icon', DeleteIcon);

const router = new VueRouter({
    mode: 'history',
    routes: [
        {
            path: '/bank/portal',
            name: 'portal',
            component: BankPortal
        },{
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
        },{
            path: '/bank/accounts/:accountId',
            name: 'account',
            component: AccountDashboard
        }
    ]
});

Vue.component('category-modal', require('@modals/CategoryModal.vue'));
Vue.component('account-category-modal', require('@modals/AccountCategoryModal.vue'));
Vue.component('transaction-modal', require('@modals/TransactionModal.vue'));
Vue.component('account-modal', require('@modals/AccountModal.vue'));
Vue.component('interest-modal', require('@modals/InterestModal.vue'));
Vue.component('profile-modal', require('@modals/ProfileModal.vue'));
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
        ...mapActions('accounts', ['fetchAllBankAccounts']),
        ...mapMutations('accounts', ['setCurrentById']),
        ...mapActions('bank', ['fetchBank']),
    },
    created() {
        let vm = this;
        this.fetchBank();
        this.fetchAllBankAccounts().then( () => {
            if (vm.$route.params.accountId)
                vm.setCurrentById(vm.$route.params.accountId);
        });
    },

});
