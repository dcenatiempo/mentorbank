require('./bootstrap');

import GlobalMixin from './GlobalMixin';
import {mapState, mapGetters, mapActions, mapMutations} from 'vuex';

Vue.component('bank-dashboard', require('./components/bank/BankDashboard.vue'));
Vue.component('profile', require('./components/bank/Profile.vue'));
Vue.component('category-modal', require('./components/modals/CategoryModal.vue'));
Vue.component('transaction-modal', require('./components/modals/TransactionModal.vue'));
Vue.component('account-modal', require('./components/modals/AccountModal.vue'));
Vue.component('add-transaction-btn', require('./components/reusable/AddTransactionBtn.vue'));

const app = new Vue({
    el: '#bank',
    mixins  : [ GlobalMixin ],
    computed: {
        ...mapState('user',['type', 'loading']),
        ...mapState(['accounts']),
        ...mapGetters('app', ['bankPage'])
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
