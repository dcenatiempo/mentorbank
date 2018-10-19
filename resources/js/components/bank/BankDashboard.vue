<template>
<div id="dashboard">

    <h1 class="top-section"><router-link to="/bank/settings">{{bank.name}}</router-link> Dashboard</h1>

    <section class="card-container">
        <div class="card">
            <h2 class="card-header">
                <router-link to="/bank/accounts">Accounts</router-link>
                <button v-on:click="showAccountModal">+</button>
            </h2>
            <template v-for="account in accounts.accountList">
                <div :key="account.id">
                    <h3>{{account.accountHolder.name}} ${{account.balance}}</h3>
                </div>
            </template>
        </div>

        <div class="card">
            <h2 class="card-header"><router-link to="/bank/categories">Categories</router-link><button v-on:click="showCategoryModal">+</button></h2>
            <template v-for="category in categories.categoryList">
                <div :key="'c-'+category.id">
                    <h3>{{category.name}}</h3>
                </div>
            </template>
        </div>

        <div class="card">
            <h2 class="card-header"><router-link to="/bank/transactions">Transactions</router-link><button v-on:click="showTransactionModal">+</button></h2> 
            <template v-for="transaction in transactions.transactionList">
                <div :key="'t-'+transaction.id">
                    <h3>{{transaction.date}} {{transaction.type}} ${{transaction.net_amount}} {{accounts.accountList.find( item => item.id == transaction.account_id).accountHolder.name}}</h3>
                </div>
            </template>
        </div>

        <div class="card">
            <h2 class="card-header">Recurring Transactions</h2>
        </div>
    </section>

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

<style lang="scss">
#dashboard {
    display: grid;
    grid-gap: 1rem;
    
    .top-section {
        background: white;
        grid-column: 1 / end;
    }

    .card-container {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
        grid-gap: 1rem;

        .card {
            padding: 1rem;
            background: white;

            .card-header {
                display: flex;
                justify-content: space-between;
            }
        }
    }
    
}
    
</style>
