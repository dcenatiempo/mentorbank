require('./bootstrap');

import GlobalMixin from './GlobalMixin';

const app = new Vue({
    el: '#auth',
    mixins  : [ GlobalMixin ],
});
