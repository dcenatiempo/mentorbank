require('./bootstrap');

import GlobalMixin from './GlobalMixin';
import {mapState, mapGetters, mapActions, mapMutations} from 'vuex';

Vue.component('onboarding', require('./components/onboarding/onboarding.vue'));

const app = new Vue({
    el: '#onboarding',
    mixins  : [ GlobalMixin ],
    computed: {
    },
    created() {
    },

});
