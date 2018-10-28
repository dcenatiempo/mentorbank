<template>
<modal  :id="id"
        modal-title="Update Interest"
        click-text="Update"
        cancel-text="Cancel"
        @handle-modal-click="saveInterest"
        @handle-modal-cancel="closeModal"
        :disabled="disabled">
        
    <!-- <label>Account</label>
    <h3 v-if="singleAccountMode">{{currentAccount.accountHolder.name}}</h3>
    <account-selector v-else ref="accountSelector" @select="onUpdateAccount"></account-selector> -->

    <h2>Interest Rate: {{displayRate}}% per&nbsp;
        <select v-model="rateDisplayInterval">
            <option value="year">year</option>
            <option value="month">month</option>
            <option value="week">week</option>
            <option value="day">day</option>
        </select>
    </h2>
    
    <p v-if="wOrM">Paid {{frequencyFullDescription}}</p>
    <select v-model="frequency">
        <option value="P1W">P1W</option>
        <option value="P2W">P2W</option>
        <option value="P4M">P4M</option>
        <option value="P1M">P1M</option>
    </select>
</modal>
</template>

<script>
import {mapState, mapMutations, mapActions} from 'vuex';

import Modal from './Modal.vue';
// import AccountSelector from '@reusable/AccountSelector.vue';
// import Datepicker from 'vuejs-datepicker';

export default {
    components: {
        Modal,
    },
    props: {},
    data() {
        return {
            id: 'interest-modal',
            mode: 'update',
            accountId: null,
            interestRate: null,
            rateDisplayInterval: null,
            frequency: null,
            distributionDay: null
        };
    },
    computed: {
        ...mapState('app', ['modalPayload']),
        // ...mapState('accounts', ['currentAccount']),
        singleAccountMode () {
           return this.$route.params && this.$route.params.accountId;
        },
        disabled() {
            return false;
        },
        wOrM() {
            if (!this.frequency) return null;
            return this.frequency[2];
        },
        displayRate() {
            let divisor = 1;
            if (this.rateDisplayInterval == 'month') divisor = 12;
            else if (this.rateDisplayInterval == 'week') divisor = 52;
            else if (this.rateDisplayInterval == 'day') divisor = 365;
            return Math.round((this.interestRate * 1000  / divisor))/1000;
        },
        frequencyFullDescription() {
            if (this.wOrM == 'W') {
                if (!this.distributionDay) return '';
                // every 2 weeks on monday
                let day = moment().isoWeekday(this.distributionDay).format('dddd');
                let freq = this.frequency[1] > 1 ? this.frequency[1]  : '';
                let s = this.frequency[1] == 1 ? '' : 's'
                return `every ${freq} week${s} on ${day}`;
            } else if (this.wOrM == 'M') {
                // monthly on the 5th
                let day = this.distributionDay;
                return 'monthly on the ' + this.ordinal_suffix_of(day);
            } else
                return '';
        },
        
    },
    methods: {
        ...mapMutations('app', ['hideModal']),
        ...mapActions('transactions', ['saveTransaction']),
        closeModal() {
            this.hideModal(this.id);
        },
        saveInterest() {
            let payload = {
                accountId: this.accountId,
                data: {
                    interestRate: this.interestRate,
                    rateDisplayInterval: this.rateDisplayInterval,
                    frequency: this.frequency,
                    distributionDay: this.distributionDay
                }
            }
            this.updateAccount(payload)
            .then( () => {
                this.closeModal();
            }).catch( () => {

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
        // onUpdateAccount(account) {
        // },
    },
    created() {},
    mounted() {},
    watch: {
        modalPayload(payload) {
            if(!payload["interest-modal"]) return;
            this.accountId = payload["interest-modal"].accountId;
            this.interestRate = payload["interest-modal"].interestRate;
            this.rateDisplayInterval= payload["interest-modal"].rateDisplayInterval;
            this.frequency= payload["interest-modal"].frequency;
            this.distributionDay= payload["interest-modal"].distributionDay;
        }
    }
}
</script>

<style lang="scss">
#interest-modal {

}
</style>