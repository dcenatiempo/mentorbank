require('./bootstrap');

import GlobalMixin from './GlobalMixin';
import {mapState, mapGetters, mapActions, mapMutations} from 'vuex';

import VueRouter from 'vue-router';
Vue.use(VueRouter);

import Onboarding from './components/onboarding/Onboarding.vue';

const router = new VueRouter({
    mode: 'history',
    routes: [
        {
            path: '/onboarding',
            name: 'onboarding',
            component: Onboarding
        }
    ]
});

const app = new Vue({
    el: '#onboarding',
    router: router,
    mixins  : [ GlobalMixin ],
    computed: {
    },
    created() {
    },

});
