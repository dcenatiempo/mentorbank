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
        ...mapActions('bank', ['getBank']),
        ...mapActions('accounts', ['getAllBankAccounts']),
        
    },
    created() {
        this.getBank();
        this.getAllBankAccounts();
    },
    mounted() {
        console.log('BankerProfile.vue mounted.')
    },
    watch: {}
}
</script>

<style>

</style>