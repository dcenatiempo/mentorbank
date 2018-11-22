require('./bootstrap');

import GlobalMixin from './GlobalMixin';

Vue.component('account-view', require('./components/account/AccountView.vue'));
Vue.component('account-header', require('./components/header/AccountHeader.vue'));

const app = new Vue({
    el: '#account',
    mixins  : [ GlobalMixin ],
});
