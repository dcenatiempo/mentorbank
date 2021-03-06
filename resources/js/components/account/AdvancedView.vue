<template>

    <section class="card-container">

        <div class="card">
            <h2>Balance: <currency :amount="currentAccount.balance"></currency></h2>
            <h2>Interest Rate: {{currentAccount.interestRate}}% per {{currentAccount.rateInterval}}</h2>
            <div class="row">
                <span v-if="wOrM">Paid {{frequencyFullDescription}}</span>
            </div>
            
        </div>

        <subscribed-categories></subscribed-categories>

        <recent-transactions
            :transaction-list="currentAccount.transactions"
            context="account"></recent-transactions>

    </section> 

</template>

<script>
import {mapState, mapGetters, mapActions, mapMutations} from 'vuex';
import Currency from '@reusable/Currency';
import SubscribedCategories from '@reusable/SubscribedCategories';
import RecentTransactions from '@reusable/RecentTransactions';
import Pencil from 'icons/pencil';

export default {
    components: {
        Currency,
        RecentTransactions,
        SubscribedCategories,
        'edit': Pencil
    },
    props: {
        accountId: Number
    },
    data() {
        return {
        };
    },
    computed: {
        ...mapState('categories', ['categoryList']),
        ...mapState('accounts', ['currentAccount']),
        ...mapGetters('accounts', { 'subedCats': 'accountSubedCats'}),
        // ...mapGetters()
        wOrM() {
            if (!this.currentAccount.frequency) return null;
            return this.currentAccount.frequency[2];
        },
        frequencyFullDescription() {
            let frequency = this.currentAccount.frequency;
            let distributionDay = this.currentAccount.distributionDay;
            if (this.wOrM == 'W') {
                if (!distributionDay) return '';
                // every 2 weeks on monday
                let day = moment().isoWeekday(distributionDay).format('dddd');
                let freq = frequency[1] > 1 ? frequency[1]  : '';
                let s = frequency[1] == 1 ? '' : 's'
                return `every ${freq} week${s} on ${day}`;
            } else if (this.wOrM == 'M') {
                // monthly on the 5th
                let day = distributionDay;
                return 'monthly on the ' + this.ordinal_suffix_of(day);
            } else
                return '';
        },
        // displayRate() {
        //     let divisor = 1;
        //     if (this.currentAccount.rateInterval == 'month') divisor = 12;
        //     else if (this.currentAccount.rateInterval == 'week') divisor = 52;
        //     else if (this.currentAccount.rateInterval == 'day') divisor = 365;
        //     return Math.round((this.currentAccount.interestRate * 1000  / divisor))/1000;
        // }
    },
    methods: {
        ...mapMutations('app', ['showModal', 'hideModal']),
        ...mapMutations('accounts',['setCurrentById']),
        ...mapActions('accounts', ['fetchBankAccount']),
        ...mapActions('categories', ['fetchAllCategories']),
        ...mapActions('transactions', ['fetchAllTransactions']),
        ...mapActions('app', ['changePage']),
        showInterestModal() {
            this.showModal({
                modalId: 'interest-modal',
                payload: {
                    accountId: this.$route.params.accountId,
                    interestRate: this.currentAccount.interestRate,
                    rateInterval: this.currentAccount.rateInterval,
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
        // if (this.categoryList.length == 0) {
        //     this.fetchAllCategories();
        // }
        // TODO
        if (!this.currentAccount.id) {
            this.fetchBankAccount(this.accountId)
        }
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
    
    .row {
        display: flex;
        align-content: center;
    }

    .top-section {
        background: white;
        grid-column: 1 / end;
        padding: 1rem;
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
