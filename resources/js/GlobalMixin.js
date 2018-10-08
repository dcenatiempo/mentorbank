import store from './store';
import {mapState, mapGetters, mapActions, mapMutations} from 'vuex';


export default {
    store,

    components: {
        // 'hashtags-modal': () => import('./components/Modals/HashtagsModal.vue'),
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

    },

    methods: {
        ...mapActions('user', ['getUser']),
    },

    computed: {
    }
}
