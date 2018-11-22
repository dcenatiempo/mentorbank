require('./bootstrap');

import GlobalMixin from './GlobalMixin';
import {mapState, mapGetters, mapActions, mapMutations} from 'vuex';

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
        let vm = this;
        this.fetchBank();
        this.fetchAllBankAccounts();//.then( () => {
        //     if (vm.$route.params.accountId)
        //         vm.setCurrentById(vm.$route.params.accountId);
        // });
    },

});
