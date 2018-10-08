<template>
<div>
    <h1>{{bank.name}}</h1>
    <h2>You don't have any accounts, lets set one up!</h2>
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
        console.log('NewBanker.vue mounted.')
    },
    watch: {}
}
</script>

<style>

</style>