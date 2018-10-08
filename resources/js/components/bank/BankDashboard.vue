<template>
    <h1>{{bank.name}} Dashboard</h1>
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
        ...mapState('user', ['name']),
        ...mapState(['bank'])
        // ...mapGetters()
    },
    methods: {
        // ...mapMutations(),
        // ...mapActions(),
        
    },
    created() {},
    mounted() {
        console.log('BankDashboard.vue mounted.')
    },
    watch: {}
}
</script>

<style>

</style>
