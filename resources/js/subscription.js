require('./bootstrap');

import GlobalMixin from './GlobalMixin';
import {mapState, mapGetters, mapActions, mapMutations} from 'vuex';

import VueRouter from 'vue-router';
Vue.use(VueRouter);
import Subscription from './components/subscription/Subscription.vue';

import DeleteIcon from 'icons/delete';
Vue.component('delete-icon', DeleteIcon);

// Vue.component('category-modal', require('@modals/CategoryModal.vue'));
// Vue.component('add-transaction-btn', require('@reusable/AddTransactionBtn.vue'));

const app = new Vue({
    el: '#subscription',
    router: new VueRouter({
        mode: 'history',
        routes: [
            {
                path: '/subscription',
                name: 'subscription',
                component: Subscription
            },
        ]
    }),
    mixins  : [ GlobalMixin ],
    computed: {
        ...mapState('user',['type', 'loading']),
        ...mapState(['accounts']),
        ...mapState('bank',['downgradeBank']),
    },
    methods: {
        ...mapActions('accounts', ['fetchAllBankAccounts']),
        ...mapMutations('accounts', ['setCurrentById']),
        ...mapActions('bank', ['fetchBank']),
        ...mapActions('categories', ['fetchAllCategories'])
    },
    created() {
        let vm = this;
        this.fetchBank();
        this.fetchAllBankAccounts().then( () => {
            if (vm.$route.params.accountId)
                vm.setCurrentById(vm.$route.params.accountId);
        });
        this.fetchAllCategories();
    },
    watch: {}
});
