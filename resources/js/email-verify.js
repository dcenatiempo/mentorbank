require('./bootstrap');

import GlobalMixin from './GlobalMixin';

const app = new Vue({
    el: '#email-verify',
    mixins  : [ GlobalMixin ],
});
