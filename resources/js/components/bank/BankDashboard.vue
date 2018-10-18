<template>
<div>
    <h1>{{bank.name}} Dashboard</h1>
    <hr>
    <h2><router-link to="/bank/accounts">Accounts</router-link><button v-on:click="showAccountModal">+</button></h2>
    <template v-for="account in accounts.accountList">
        <div :key="account.id">
            <h3>{{account.accountHolder.name}}</h3>
        </div>
    </template>
    <hr>
    <h2><router-link to="/bank/categories">Categories</router-link><button v-on:click="showCategoryModal">+</button></h2>
    <template v-for="category in categories.categoryList">
        <div :key="'c-'+category.id">
            <h3>{{category.name}}</h3>
        </div>
    </template>
    <hr>
    <h2><router-link to="/bank/transactions">Transactions</router-link><button v-on:click="showTransactionModal">+</button></h2> 
    <template v-for="transaction in transactions.transactionList">
        <div :key="'t-'+transaction.id">
            <h3>{{transaction.type}} ${{transaction.net_amount}}</h3>
        </div>
    </template>
    <hr>
    <h2>Recurring Transactions</h2>
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
        ...mapMutations('app', ['showModal', 'hideModal', 'pushPageHistory']),
        ...mapActions('categories', ['getAllCategories']),
        ...mapActions('transactions', ['getAllTransactions']),
        ...mapActions('app', ['changePage']),
        showCategoryModal() {
            this.showModal({
                modalId: 'category-modal',
                payload: {mode: "add"}
            });
        },
        showAccountModal() {
            this.showModal({
                modalId: 'account-modal',
                payload: {mode: "add"}
            });
        },
        showTransactionModal() {
            this.showModal({
                modalId: 'transaction-modal',
                payload: {mode: "add"}
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
