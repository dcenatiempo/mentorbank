<template>
    <div class="overlay" v-show="showOverlay">
        <slot></slot>
    </div>
</template>

<script>
import {mapState, mapGetters, mapActions, mapMutations} from 'vuex';

export default {
    components: {},
    props: {},
    data() {
        return {

        };
    },
    computed: {
        // ...mapState(),
        ...mapGetters('app', ['showOverlay'])
    },
    methods: {
        // ...mapMutations(),
        // ...mapActions(),
        
    },
    created() {},
    mounted() {
        console.log('Component mounted.')
    },
    watch: {}
}
</script>

<style>
    .overlay {
        z-index: 10;
        background: rgba(60, 80, 120, .8);
        position: fixed;
        top: 0;
        bottom: 0;
        right: 0;
        left: 0;
        overflow: auto;
    }
</style>
