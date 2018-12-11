<template>
<div id="dashboard">

    <h1 class="top-section"><router-link to="/bank/settings">{{bank.name}}</router-link> Dashboard</h1>

    <section class="card-container">
        <div class="card">
            <h2 class="card-header">
                <router-link to="/bank/accounts">Accounts</router-link>
                <button v-on:click="showAccountHolderModal" class="btn-icon">+</button>
            </h2>
            <div v-if="accounts.loading"
                class="loader"></div>
            <div v-else class="account-grid">
                <template v-for="account in accounts.accountList">
                    <router-link
                        :to="`/bank/accounts/${account.id}`"
                        :key="'account-link-' + account.id">{{account.accountHolder.name}}</router-link>
                    <currency
                        :amount="account.balance"
                        :key="'account-balance-' + account.id" />
                </template>
            </div>
        </div>

        <div class="card">
            <h2 class="card-header"><router-link to="/bank/categories">Categories</router-link><button v-on:click="showCategoryModal" class="btn-icon">+</button></h2>
            <template v-for="category in categories.categoryList">
                <div :key="'c-'+category.id">
                    <h3>{{category.name}}</h3>
                </div>
            </template>
        </div>

        <recent-transactions
            :transaction-list="transactions.transactionList"
            context="bank"></recent-transactions>

        <div class="card">
            <h2 class="card-header">Recurring Transactions</h2>
            <p>Coming Soon!</p>
        </div>
    </section>

</div>
</template>

<script>
import {mapState, mapGetters, mapActions, mapMutations} from 'vuex';
import Currency from '@reusable/Currency';
import RecentTransactions from '@reusable/RecentTransactions';
import BankTransfer from 'icons/BankTransfer';
import BankTransferIn from 'icons/BankTransferIn';
import BankTransferOut from 'icons/BankTransferOut';
import Pencil from 'icons/pencil';

export default {
    components: {
        Currency,
        RecentTransactions,
        'transfer': BankTransfer,
        'deposit': BankTransferIn,
        'withdrawal': BankTransferOut,
        'edit': Pencil
    },
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
        ...mapMutations('accounts',['unSetCurrent']),
        ...mapActions('categories', ['fetchAllCategories']),
        ...mapActions('transactions', ['fetchAllTransactions']),
        moment(d) {
            return moment(d);
        },
        showCategoryModal() {
            this.showModal({
                modalId: 'category-modal',
                payload: {mode: "add"}
            });
        },
        showAccountHolderModal() {
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
        if (0 == this.categories.categoryList.length) {
            this.fetchAllCategories();
        }
        if (false == this.transactions.hasBeenLoaded) {
            this.fetchAllTransactions();
        }
    },
    mounted() {
        this.unSetCurrent();
    },
    watch: {}
}
</script>

<style lang="scss">
@import 'resources/sass/variables';

#dashboard {
    display: grid;
    grid-gap: 1rem;
    
    .top-section {
        background: white;
        grid-column: 1 / end;
        padding: 1rem;
    }

    .account-grid {
        display: grid;
        grid-template-columns: 1fr min-content;

        .currency {
            justify-self: end;
        }
        a {
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        > * {
            font-size: 1.5rem;
        }
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

    table {
        width: 100%;

        tr:nth-child(even) {
            background-color: $lightgray;
        }

        td {
            &.align-right {
                text-align: right;
            }
        }
    }
}  
</style>
