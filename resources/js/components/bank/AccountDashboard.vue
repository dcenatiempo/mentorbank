<template>
<div id="dashboard">

    <h1 class="top-section">{{currentAccount.accountHolder.name}} Account Dashboard</h1>
    <h2>Balance: ${{currentAccount.balance}}</h2>
    <h2>Interest Rate: {{displayRate}}% per&nbsp;
        <select v-model="displayInterval">
            <option value="year">year</option>
            <option value="month">month</option>
            <option value="week">week</option>
            <option value="day">day</option>
        </select>
    </h2>
    <button v-on:click="showInterestModal">Edit</button>
    
    <p v-if="wOrM">Paid {{frequencyFullDescription}}</p>

    <section class="card-container">
        <div class="card">
            <h2 class="card-header"><router-link to="/account/categories">Categories</router-link><button v-on:click="showCategoryModal">+</button></h2>
            <template v-for="category in subedCats">
                <div :key="'c-'+category.id">
                    <h3>{{getCategoryName(category.categoryId)}} ${{category.balance}}</h3>
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
            displayInterval: 'year',
            frequency: 'P1W'
        };
    },
    computed: {
        ...mapState('categories', ['categoryList']),
        ...mapState('accounts', ['currentAccount']),
        ...mapState({ 'subedCats': state => state.accounts.currentAccount.subscribedCategories}),
        // ...mapGetters()
        wOrM() {
            if (!this.frequency) return null;
            return this.frequency[2];
        },
        frequencyFullDescription() {
            if (this.wOrM == 'W') {
                if (!this.currentAccount.distributionDay) return '';
                // every 2 weeks on monday
                let day = moment().isoWeekday(this.currentAccount.distributionDay).format('dddd');
                let freq = this.frequency[1] > 1 ? this.frequency[1]  : '';
                let s = this.frequency[1] == 1 ? '' : 's'
                return `every ${freq} week${s} on ${day}`;
            } else if (this.wOrM == 'M') {
                // monthly on the 5th
                let day = this.currentAccount.distributionDay;
                return 'monthly on the ' + this.ordinal_suffix_of(day);
            } else
                return '';
        },
        displayRate() {
            let divisor = 1;
            if (this.displayInterval == 'month') divisor = 12;
            else if (this.displayInterval == 'week') divisor = 52;
            else if (this.displayInterval == 'day') divisor = 365;
            return Math.round((this.currentAccount.interestRate * 1000  / divisor))/1000;
        }
    },
    methods: {
        ...mapMutations('app', ['showModal', 'hideModal']),
        ...mapMutations('accounts',['setCurrentById']),
        ...mapActions('categories', ['fetchAllCategories']),
        ...mapActions('transactions', ['fetchAllTransactions']),
        ...mapActions('app', ['changePage']),
        showInterestModal() {
            this.showModal({
                modalId: 'interest-modal',
                payload: {
                    accountId: this.$route.params.accountId,
                    interestRate: this.currentAccount.interestRate,
                    rateDisplayInterval: this.currentAccount.rateDisplayInterval,
                    frequency: this.currentAccount.frequency,
                    distributionDay: this.currentAccount.distributionDay
                }
            });
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
                payload: {
                    mode: "add",
                    account: this.$route.params.accountId
                }
            });
        },
        getCategoryName(id) {
            if (this.categoryList.length == 0) return '';
            let name = this.categoryList.find( cat => cat.id == id).name;
            return name;
        },
        ordinal_suffix_of(i) {
            var j = i % 10,
                k = i % 100;
            if (j == 1 && k != 11) {
                return i + "st";
            }
            if (j == 2 && k != 12) {
                return i + "nd";
            }
            if (j == 3 && k != 13) {
                return i + "rd";
            }
            return i + "th";
        }
    },
    created() {
        if (this.categoryList.length == 0) {
            this.fetchAllCategories();
        }
        this.setCurrentById(this.$route.params.accountId);
    },
    mounted() {
        
    },
    watch: {
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