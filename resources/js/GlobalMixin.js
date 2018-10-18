import store from './store';
import {mapState, mapGetters, mapActions, mapMutations} from 'vuex';
import DefaultHeader from './components/header/DefaultHeader.vue';
import DefaultFooter from './components/footer/DefaultFooter.vue';

export default {
    store,

    components: {
        DefaultHeader,
        DefaultFooter
    },

    data() {
        return {

        };
    },

    created() {},

    mounted() {
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
