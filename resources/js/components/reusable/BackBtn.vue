<template>
    <a disabled="!isDashboard" v-on:click.prevent="goBack">
        <back-icon v-show="!isDashboard"></back-icon>
    </a>
</template>

<script>
import {mapState, mapGetters, mapActions, mapMutations} from 'vuex';
import BackIcon from 'icons/ArrowLeft';

export default {
    components: {
        BackIcon,
    },
    props: {},
    data() {
        return {
            isDashboard: null,
        };
    },
    computed: {
        // ...mapState(),
        // ...mapGetters()
    },
    methods: {
        ...mapMutations('app', ['showModal']),
        // ...mapActions(),
        goBack() {
            if (this.isDashboard) return;

            this.$router.go(-1);
        },
    },
    created() {},
    mounted() {
        // console.log(this.$router.currentRoute)
        this.isDashboard = this.$router.currentRoute.name == 'dashboard';
    },
    watch: {
        '$route' (to, from) {
            this.isDashboard = to.name == 'dashboard';
        }
    }
}
</script>

<style scoped>
    button {
        position: fixed;
        bottom: 20px;
        right: 20px;
        border-radius: 50%;
        background: rgb(103, 146, 37);
        color: white;
    }
</style>
