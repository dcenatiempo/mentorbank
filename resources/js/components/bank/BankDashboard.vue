<template>
<div>
    <h1>{{bank.name}} Dashboard</h1>
    <hr>
    <h2>Accounts</h2>
    <template v-for="account in accounts.accountList">
        <div :key="account.id">
            <h3>{{account.accountHolder.name}}</h3>
        </div>
    </template>
    <hr>
    <h2>Categories</h2>
    <template v-for="category in categories.categoryList">
        <div :key="'c-'+category.id">
            <h3>{{category.name}}</h3>
        </div>
    </template>
    <hr>
    <h2>Transactions</h2> 
    <template v-for="transaction in transactions.transactionList">
        <div :key="'t-'+transaction.id">
            <h3>{{transaction.type}} ${{transaction.net_amount}}</h3>
        </div>
    </template>
    <hr>
    <h2>Recurring Transactions</h2>
    <button v-on:click="showExampleModal">Open Modal</button>
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
        ...mapState(['bank', 'accounts', 'categories', 'transactions'])
        // ...mapGetters()
    },
    methods: {
        ...mapMutations('app', ['showModal', 'hideModal']),
        ...mapActions('categories', ['getAllCategories']),
        ...mapActions('transactions', ['getAllTransactions']),
        showExampleModal() {
            this.showModal({
                modalId: 'example-modal',
                payload: {message: "Hello World"}
            });
        }
    },
    created() {
        this.getAllCategories();
        this.getAllTransactions();
    },
    mounted() {
        console.log('BankDashboard.vue mounted.')
    },
    watch: {}
}
</script>

<style>

</style>
