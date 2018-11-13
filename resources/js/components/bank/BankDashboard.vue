<template>
<div id="dashboard">

    <h1 class="top-section"><router-link to="/bank/settings">{{bank.name}}</router-link> Dashboard</h1>

    <section class="card-container">
        <div class="card">
            <h2 class="card-header">
                <router-link to="/bank/accounts">Accounts</router-link>
                <button v-on:click="showAccountModal" class="btn-icon">+</button>
            </h2>
            <template v-if="accounts.loading">
                <div class="loader"></div>
            </template>
            <template v-else v-for="account in accounts.accountList">
                <div :key="account.id">
                    <h3><router-link :to="`/bank/accounts/${account.id}`">{{account.accountHolder.name}}</router-link> <currency :amount="account.balance"></currency></h3>
                </div>
            </template>
        </div>

        <div class="card">
            <h2 class="card-header"><router-link to="/bank/categories">Categories</router-link><button v-on:click="showCategoryModal" class="btn-icon">+</button></h2>
            <template v-for="category in categories.categoryList">
                <div :key="'c-'+category.id">
                    <h3>{{category.name}}</h3>
                </div>
            </template>
        </div>

        <div class="card">
            <h2 class="card-header">Recent Transactions</h2> 
            <template v-if="accounts.loading">
                <div class="loader"></div>
            </template>

            <table v-else>
                <template class="transaction-grid"  v-for="transaction in transactions.transactionList.slice(0, 10)">
                    <tr :key="'t-'+transaction.id" class="row">
                        <td>{{moment(transaction.createdAt.date).format('ddd, MMM DD')}}</td>
                        <td>
                            {{accounts.accountList.find( item => item.id == transaction.accountId).accountHolder.name}}
                        </td>
                        <td>
                            <transfer v-if="transaction.type == 'transfer'" class="transfer"></transfer>
                            <deposit v-else-if="transaction.type == 'deposit'" class="deposit"></deposit>
                            <withdrawal v-else-if="transaction.type == 'withdrawal'" class="withdrawal"></withdrawal>
                        </td>
                        <td class="align-right">
                            <currency :amount="transaction.netAmount"></currency>
                        </td>
                        <!-- <td>
                            <button v-on:click="editTransaction" class="btn-icon"><edit></edit></button>
                        </td> -->
                    </tr>
                </template>
            </table>

        </div>

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
import BankTransfer from 'icons/BankTransfer';
import BankTransferIn from 'icons/BankTransferIn';
import BankTransferOut from 'icons/BankTransferOut';
import Pencil from 'icons/pencil';

export default {
    components: {
        Currency,
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
        ...mapActions('app', ['changePage']),
        moment(d) {
            return moment(d);
        },
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
        this.fetchAllCategories();
        this.fetchAllTransactions();
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

    .transfer {
        color: $purple;
    }
    .deposit {
        color: $green;
    }
    .withdrawal {
        color: $red;
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
