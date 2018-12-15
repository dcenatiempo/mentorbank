require('./bootstrap');

import GlobalMixin from './GlobalMixin';
import {mapState, mapActions, mapMutations} from 'vuex';

Vue.component('account-header', require('@components/header/AccountHeader.vue'));
Vue.component('bank-portal', require('@components/bank/BankPortal.vue'));

const app = new Vue({
    el: '#portal',
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
        this.fetchBank();
        this.fetchAllBankAccounts();
    },

});
