import store from './store';
import {mapState, mapGetters, mapActions, mapMutations} from 'vuex';
import DefaultHeader from './components/header/DefaultHeader.vue';

export default {
    store,

    components: {
        'default-header': DefaultHeader
    },

    data() {
        return {

        };
    },

    created() {},

    mounted() {
        console.log('Global Mixin Loaded');
        let vm = this;
        this.getUser();

        // check to if device is a touch device
        window.addEventListener('touchstart', function onFirstTouch() {
            vm.setTouchDevice();
            window.removeEventListener('touchstart', onFirstTouch, false);
        }, false);

    },

    methods: {
        ...mapActions('user', ['getUser']),
        ...mapMutations('app', ['setTouchDevice']),
    },

    computed: {
    }
}
