require('./bootstrap');

import GlobalMixin from './GlobalMixin';

const app = new Vue({
    el: '#password-reset',
    mixins  : [ GlobalMixin ],
});
