require('./bootstrap');

import GlobalMixin from './GlobalMixin';
import {mapState, mapGetters, mapActions, mapMutations} from 'vuex';

Vue.component('new-user', require('./components/profile/NewUser.vue'));
Vue.component('banker-profile', require('./components/profile/BankerProfile.vue'));
Vue.component('account-holder-profile', require('./components/profile/AccountHolderProfile.vue'));

const app = new Vue({
    el: '#profile',
    mixins  : [ GlobalMixin ],
    computed: {
        ...mapState('user',['type', 'loading'])
    },
    created() {
        // fetch user profile
    },

});
