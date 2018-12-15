import store from './store';
import {mapState, mapGetters, mapActions, mapMutations} from 'vuex';
import DefaultHeader from '@components/header/DefaultHeader.vue';
import DefaultFooter from '@components/footer/DefaultFooter.vue';
import Overlay from '@reusable/Overlay.vue';

export default {
    store,
    components: {
        DefaultHeader,
        DefaultFooter,
        Overlay
    },
    data() {
        return {
        };
    },
    created() {},
    mounted() {
        let vm = this;

        if (this.isLoggedIn)
            this.fetchUser();

        // check to if device is a touch device
        window.addEventListener('touchstart', function onFirstTouch() {
            vm.setTouchDevice();
            window.removeEventListener('touchstart', onFirstTouch, false);
        }, false);
    },
    methods: {
        ...mapActions('user', ['fetchUser']),
        ...mapMutations('app', ['setTouchDevice']),
    },
    computed: {
        ...mapState('app', ['isLoggedIn']),
    }
};
