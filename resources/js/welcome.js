require('./bootstrap');

import GlobalMixin from './GlobalMixin';

const app = new Vue({
    el: '#welcome',
    mixins  : [ GlobalMixin ],
    components: {},
});
