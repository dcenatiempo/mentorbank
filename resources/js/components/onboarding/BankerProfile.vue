<template>
<div>
    <h1>Welcome {{user.name}}</h1>
    <h2>{{bank.name}}</h2>
</div>
</template>

<script>
import {mapState, mapGetters, mapActions, mapMutations} from 'vuex';

export default {
    computed: {},
    props: {},
    data() {
        return {

        };
    },
    computed: {
        ...mapState(['user', 'bank']),
        // ...mapGetters()
    },
    methods: {
        // ...mapMutations(),
        ...mapActions('bank', ['fetchBank']),
        ...mapActions('accounts', ['fetchAllBankAccounts']),
        
    },
    created() {
        this.fetchBank();
        this.fetchAllBankAccounts();
    },
    mounted() {},
    watch: {}
}
</script>

<style>

</style>