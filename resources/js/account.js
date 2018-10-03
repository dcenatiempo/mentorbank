require('./bootstrap');

import GlobalMixin from './GlobalMixin';

Vue.component('example-component', require('./components/ExampleComponent.vue'));

const app = new Vue({
    el: '#account',
    mixins  : [ GlobalMixin ],
});
