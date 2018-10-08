require('./bootstrap');

import GlobalMixin from './GlobalMixin';
import {mapState, mapGetters, mapActions, mapMutations} from 'vuex';

Vue.component('new-bank', require('./components/bank/NewBank.vue'));
Vue.component('banker-profile', require('./components/bank/BankDashboard.vue'));

const app = new Vue({
    el: '#bank',
    mixins  : [ GlobalMixin ],
    computed: {
        ...mapState('user',['type', 'loading']),
        ...mapState(['accounts'])
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
