<template>
<modal  :id="id"
        modal-title="Update Interest"
        click-text="Update"
        cancel-text="Cancel"
        @handle-modal-click="saveInterest"
        @handle-modal-cancel="closeModal"
        :disabled="disabled">
        
    <input type="number" min="0" max="1000" step=".1" v-model="interestRate"/>
    <span>% per</span>
    <select v-model="rateInterval">
        <option value="year">year</option>
        <option value="month">month</option>
        <option value="week">week</option>
        <option value="day">day</option>
    </select>

    <span>Paid every:</span>
    <input
        type="number"
        step="1"
        min="1"
        :max="frequency.unit === 'W' ? 4 : 2"
        v-model="frequency.time"/>
    <select v-model="frequency.unit">
        <option value="M">month{{frequency.time == 1 ? '' : 's'}}</option>
        <option value="W">week{{frequency.time == 1 ? '' : 's'}}</option>
    </select>

    <template v-if="frequency.unit == 'W'">
        <span>on</span>
        <select v-model="distributionDay">
            <option value="1">Monday</option>
            <option value="2">Tuesday</option>
            <option value="3">Wednesday</option>
            <option value="4">Thursday</option>
            <option value="5">Friday</option>
            <option value="6">Saturday</option>
            <option value="7">Sunday</option>
        </select>
    </template>
    <template v-if="frequency.unit == 'M'">
        <span>on the</span>
        <select v-model="distributionDay">
            <option v-for="n in 31"
                :value="n"
                :key="n">{{ordinal_suffix_of(n)}}</option>
        </select>
    </template>
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
            rateInterval: null,
            frequency: {
                time: null,
                unit: null
            },
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
            if (this.rateInterval == 'month') divisor = 12;
            else if (this.rateInterval == 'week') divisor = 52;
            else if (this.rateInterval == 'day') divisor = 365;
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
        ...mapActions('accounts',['updateAccount']),
        ...mapActions('transactions', ['saveTransaction']),
        closeModal() {
            this.hideModal(this.id);
        },
        saveInterest() {
            let f = this.frequency;
            let payload = {
                accountId: this.accountId,
                data: {
                    interestRate: this.interestRate,
                    rateInterval: this.rateInterval,
                    frequency: `P${f.time}${f.unit}`,
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
            this.rateInterval= payload["interest-modal"].rateInterval;
            this.frequency.time= payload["interest-modal"].frequency.split('')[1];
            this.frequency.unit= payload["interest-modal"].frequency.split('')[2];
            this.distributionDay= payload["interest-modal"].distributionDay;
        }
    }
}
</script>

<style lang="scss">
#interest-modal {
    .content {
        display: flex;
        flex-flow: row wrap;
        align-items: baseline;

        input {
            flex-shrink: 1;
            flex-basis: 50px;
            text-align: right;
        }
    }
}
</style>