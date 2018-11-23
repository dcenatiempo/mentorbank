<template>
<modal  :id="id"
        modal-title="Update Interest"
        click-text="Update"
        cancel-text="Cancel"
        @handle-modal-click="saveInterest"
        @handle-modal-cancel="closeModal"
        :disabled="disabled">
        
    <div class="group">
        <h4>Interest Rate:</h4>
        <div class="row">
            <input class="interest" type="number" min="0" max="1000" step=".1" v-model="interestRate"/>
            <span>%&nbsp;</span>

            <span>per:&nbsp;</span>
            <select v-model="rateInterval">
                <option value="year">year</option>
                <option value="month">month</option>
                <option value="week">week</option>
                <option value="day">day</option>
            </select>
        </div>
    </div>

    <div class="group">
        <h4>Distribution Schedule:</h4>
        <div class="row">
            <span>Paid every:&nbsp;</span>
            <input
                class="interval"
                type="number"
                step="1"
                min="1"
                :max="frequency.unit === 'W' ? 4 : 2"
                v-model="frequency.time"/>
            <select v-model="frequency.unit">
                <option value="M">month{{frequency.time == 1 ? '' : 's'}}</option>
                <option value="W">week{{frequency.time == 1 ? '' : 's'}}</option>
            </select>
        </div>

        <div class="row">
            <span v-if="frequency.unit == 'W'">On&nbsp;</span>
            <span v-if="frequency.unit == 'M'">On the&nbsp;</span>
            <select v-model="distributionDay">
                <option v-for="option in distributionDayOptions"
                    :value="option.value"
                    :key="option.value">{{option.name}}</option>
            </select>
        </div>
    </div>
</modal>
</template>

<script>
import {mapState, mapMutations, mapActions} from 'vuex';

import Modal from './Modal.vue';
import Dropdown from 'vue-dropdowns';
// import AccountSelector from '@reusable/AccountSelector.vue';
// import Datepicker from 'vuejs-datepicker';

export default {
    components: {
        Modal,
        Dropdown
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
            distributionDay: null,
            weekOptions: [
                { name: 'Monday', value: 1 },
                { name: 'Tuesday', value: 2 },
                { name: 'Wednesday', value: 3 },
                { name: 'Thursday', value: 4 },
                { name: 'Friday', value: 5 },
                { name: 'Saturday', value: 6 },
                { name: 'Sunday', value: 7 }
            ],
            object: {
              name: 'Object Name',
            }
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
        displayRate() {
            let divisor = 1;
            if (this.rateInterval == 'month') divisor = 12;
            else if (this.rateInterval == 'week') divisor = 52;
            else if (this.rateInterval == 'day') divisor = 365;
            return Math.round((this.interestRate * 1000  / divisor))/1000;
        },
        frequencyFullDescription() {
            if (this.frequency.unit == 'W') {
                if (!this.distributionDay) return '';
                // every 2 weeks on monday
                let day = moment().weekday(this.distributionDay).format('dddd');
                let freq = this.frequency.time > 1 ? ` ${this.frequency.time} `  : ' ';
                let s = freq >= 2 ? 's' : ''
                return `every${freq}week${s} on ${day}`;
            } else if (this.frequency.unit == 'M') {
                // monthly on the 5th
                let day = this.distributionDay;
                return 'monthly on the ' + this.ordinal_suffix_of(day);
            } else
                return '';
        },
        monthOptions() {
            let options = [];
            for (let day = 1; day <= 31; day++) {
                options.push({
                    name: this.ordinal_suffix_of(day),
                    value: day
                });
            }
            return options;
        },
        distributionDayOptions() {
            return 'W' == this.frequency.unit
                ? this.weekOptions
                : this.monthOptions;
        }
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
        selectRateInterval(val) {
            this.rateInterval = val;
        },
        selectDistributionDay(val) {
            this.distributionDay = val;
        },
        selectFreqUnit(val) {
            this.frequency.unit = val;
        }
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
        },
        'frequency.unit': function (unit) {
            if ('M' == unit) {
                 this.frequency.time = 1;
            } else if ('W' == unit) {
                let day = this.distributionDay;
                this.distributionDay = day > 7 ? 1 : day;
            }
        }
    }
}
</script>

<style lang="scss">
#interest-modal {
    .content {
        
        .group {
            margin: 1rem 0;
        }

        .row {
            display: flex;
            flex-flow: row wrap;
            align-items: baseline;
            margin-bottom: .5rem;
        }
        input {
            flex-shrink: 1;
            text-align: right;
            padding-right: 4px;

            &.interest {
                flex-basis: 55px;
            }

            &.interval {
                flex-basis: 35px;
            }
        }
    }
}
</style>