<template>
<div id="dashboard">

    <h1 class="top-section">
        {{currentAccount.accountHolder.name}}'s Account Dashboard
        <button v-on:click="showAccountModal" class="btn-icon"><edit></edit></button>
    </h1>

    <div class="top-section">
        <h2>Balance: <currency :amount="currentAccount.balance"></currency></h2>
        <h2>Interest Rate: {{currentAccount.interestRate}}% per {{currentAccount.rateInterval}}</h2>
        <div class="row">
            <span v-if="wOrM">Paid {{frequencyFullDescription}}</span>
            <button v-on:click="showInterestModal" class="btn-icon"><edit></edit></button>
        </div>
        <div>Accrued Interest: <currency :amount="currentAccount.interestAccrued" /> due {{moment(currentAccount.nextDistribution)}}</div>
    </div>

    <section class="card-container">

        <subscribed-categories></subscribed-categories>

        <recent-transactions
            :transaction-list="currentAccount.transactions"
            context="account"></recent-transactions>

       <div class="card">
            <h2 class="card-header">Recurring Transactions</h2>
            <p>Coming Soon!</p>
        </div>

        <!--
        <div class="card">
            <h2 class="card-header">Recurring Transactions</h2>
        </div>
        -->
    </section> 

</div>
</template>

<script>
import {mapState, mapGetters, mapActions, mapMutations} from 'vuex';
import Currency from '@reusable/Currency';
import RecentTransactions from '@reusable/RecentTransactions';
import SubscribedCategories from '@reusable/SubscribedCategories';
import GoalMeter from '@reusable/GoalMeter';
import Pencil from 'icons/pencil';

export default {
    components: {
        Currency,
        RecentTransactions,
        SubscribedCategories,
        GoalMeter,
        'edit': Pencil
    },
    props: {},
    data() {
        return {
        };
    },
    computed: {
        ...mapState('accounts', ['currentAccount']),
        ...mapGetters('accounts', ['accountListCount']),
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
        ...mapActions('categories', ['fetchAllCategories']),
        ...mapActions('transactions', ['fetchAllTransactions']),
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
                payload: {
                    mode: "add",
                    currentAccount: this.currentAccount
                }
            });
        },
        showAccountModal() {
            this.showModal({
                modalId: 'account-modal',
                payload: {
                    mode: "edit",
                    accountHolder: this.currentAccount.accountHolder,
                    account: {
                        view: this.currentAccount.view,
                        id: this.currentAccount.id
                     }
                }
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
        },
        moment(d) {
            if (!d) return '?';
            return moment.utc(d.date).local().fromNow();
        },
    },
    created() {
        if (this.accountListCount > 0)
            this.setCurrentById(this.$route.params.accountId);
    },
    mounted() {
        
    },
    watch: {
        accountListCount(val) {
            if (0 == val) return;
            this.setCurrentById(this.$route.params.accountId);
        }
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

    .category-grid {
        display: grid;
        grid-template-columns: minmax(auto, max-content) max-content minmax(80px, 1fr);
        font-size: 1.6em;
        justify-items: end;
        align-items: center;
        grid-column-gap: 8%;

        .cat-name {
            max-width: 100%;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            justify-self: start;
            text-align: left;
            padding: 0;
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
    
}
    
</style>
