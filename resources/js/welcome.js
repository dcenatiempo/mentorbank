require('./bootstrap');

import GlobalMixin from './GlobalMixin';

// Vue.component('example-component', require('./components/ExampleComponent.vue'));
import ExampleComponent from './components/ExampleComponent.vue';
console.log('pizza');
const app = new Vue({
    el: '#welcome',
    mixins  : [ GlobalMixin ],
    components: {
        'example-component': ExampleComponent
    }
});
