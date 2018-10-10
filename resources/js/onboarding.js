require('./bootstrap');

import GlobalMixin from './GlobalMixin';
import {mapState, mapGetters, mapActions, mapMutations} from 'vuex';

Vue.component('new-user', require('./components/onboarding/NewUser.vue'));
Vue.component('banker-profile', require('./components/onboarding/BankerProfile.vue'));
Vue.component('account-holder-profile', require('./components/onboarding/AccountHolderProfile.vue'));
Vue.component('new-bank', require('./components/onboarding/NewBank.vue'));

const app = new Vue({
    el: '#onboarding',
    mixins  : [ GlobalMixin ],
    computed: {
        ...mapState('user',['type', 'loading'])
    },
    created() {
    },

});
