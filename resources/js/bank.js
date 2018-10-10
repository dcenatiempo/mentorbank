require('./bootstrap');

import GlobalMixin from './GlobalMixin';
import {mapState, mapGetters, mapActions, mapMutations} from 'vuex';

Vue.component('bank-dashboard', require('./components/bank/BankDashboard.vue'));
Vue.component('example-modal', require('./components/modals/ExampleModal.vue'));

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
