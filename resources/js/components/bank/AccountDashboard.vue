<template>
<div id="dashboard">

    <h1 class="top-section">{{currentAccount.accountHolder.name}} Account Dashboard</h1>
    <h2> Balance: ${{currentAccount.balance}}</h2>

    <section class="card-container">
        <div class="card">
            <h2 class="card-header"><router-link to="/account/categories">Categories</router-link><button v-on:click="showCategoryModal">+</button></h2>
            <template v-for="category in subedCats">
                <div :key="'c-'+category.id">
                    <h3>{{getCategoryName(category.category_id)}} ${{category.balance}}</h3>
                </div>
            </template>
        </div>

       <!--  <div class="card">
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
        -->
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
        ...mapState('categories', ['categoryList']),
        ...mapState('accounts', ['currentAccount']),
        ...mapState({ 'subedCats': state => state.categories.currentSubscribedCats}),
        // ...mapGetters()
    },
    methods: {
        ...mapMutations('app', ['showModal', 'hideModal']),
        ...mapMutations('accounts',['setCurrentById']),
        ...mapActions('categories', ['fetchAllCategories', 'fetchSubscribedCats']),
        ...mapActions('transactions', ['fetchAllTransactions']),
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
                payload: {
                    mode: "add",
                    account: this.$route.params.id
                }
            });
        },
        getCategoryName(id) {
            if (this.categoryList.length == 0) return '';
            let name = this.categoryList.find( cat => cat.id == id).name;
            return name;
        }
    },
    created() {
        // this.fetchAllCategories();
        // this.fetchAllTransactions();
    },
    mounted() {
        this.setCurrentById(this.$route.params.id);
        this.fetchSubscribedCats(this.$route.params.id)
            .then( () => {});
    },
    watch: {
        // $route (to, from) {
        //     debugger
        //     this.setCurrentById(to.params.id)
        // }
    }
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
