<template>
<modal  :id="id"
        :modal-title="modalTitle"
        :click-text="clickText"
        cancel-text="Cancel"
        @handle-modal-click="saveNewTransaction"
        @handle-modal-cancel="closeModal"
        :disabled="disabled">
    
    <label>Date</label>
    <datepicker :value="date.__d" v-model="date"></datepicker>
    
    <label>Account</label>
    <h3 v-if="singleAccountMode">{{currentAccount.accountHolder.name}}</h3>
    <account-selector v-else ref="accountSelector" @select="onUpdateAccount"></account-selector>

    <label>Type</label>
    <div class="grid-row">
        <transaction-type-selector
            ref="typeSelector"
            @select="onUpdateType"></transaction-type-selector>
        <money
            v-bind="moneyConfig"
            v-model="netAmount"
            @input="handleMoneyChange"
            :disabled="transactionType != 'transfer'"></money>
    </div>

    <template v-if="transactionType === 'transfer'">
        <transaction-transfer @split-updated="updateSplit" :subedCats="subedCats" :amount="netAmount">
        </transaction-transfer>
    </template>

    <template v-else-if="transactionType === 'deposit'">
        <deposit-splitter @split-updated="updateSplit" :subedCats="subedCats">
        </deposit-splitter>
    </template>

    <template v-else-if="transactionType === 'withdrawal'">
        <withdrawal-splitter @split-updated="updateSplit" :subedCats="subedCats">
        </withdrawal-splitter>
    </template>

    <label>Memo</label>
    <input type="text" placeholder="optional short descrition" v-model="memo">

</modal>
</template>

<script>
import {mapState, mapMutations, mapActions} from 'vuex';

import AccountSelector from '@reusable/AccountSelector.vue';
import TransactionTypeSelector from '@reusable/TransactionTypeSelector.vue';
import DepositSplitter from '@reusable/DepositSplitter.vue';
import WithdrawalSplitter from '@reusable/WithdrawalSplitter.vue';
import TransactionTransfer from '@reusable/TransactionTransfer.vue';
import Modal from './Modal.vue';
import Datepicker from 'vuejs-datepicker';
import {Money} from 'v-money'

export default {
    components: {
        Modal,
        AccountSelector,
        TransactionTypeSelector,
        Datepicker,
        DepositSplitter,
        WithdrawalSplitter,
        TransactionTransfer,
        Money,
    },
    props: {},
    data() {
        return {
            id: 'transaction-modal',
            account: null,
            transactionType: 'deposit',
            memo: '',
            netAmount: 0,
            date: moment().format(),
            split: [],
            moneyConfig: {
                decimal: '.',
                thousands: ',',
                prefix: '$ ',
                suffix: '',
                precision: 2,
                masked: false
            },
        };
    },
    computed: {
        ...mapState('app', ['modalPayload']),
        ...mapState('accounts', ['currentAccount']),
        ...mapState({ 'subedCats': state => state.accounts.currentAccount.subscribedCategories}),
        mode() {
            let payload = this.modalPayload[this.id];
            return payload ? payload.mode : 'add';
        },
        singleAccountMode () {
           return this.$route.params && this.$route.params.accountId;
        },
        clickText() {
            if (this.mode === 'add') {
                return 'Add New'
            } else if (this.mode == 'edit') {
                return 'Save Changes'
            }
            return 'Close';
        },
        modalTitle() {
            return this.mode + ' transaction'
        },
        disabled() {
            if (!this.date) return true;
            if (!this.currentAccount.id) return true;
            if (!this.transactionType) return true;
            if (this.split.find(item => item.categoryId === null) !== undefined) return true;
            if (this.netAmount === 0) return true;
            return false;
        },
        
    },
    methods: {
        ...mapMutations('app', ['hideModal']),
        ...mapMutations('accounts',['setCurrentById', 'unSetCurrent']),
        ...mapActions('transactions', ['saveTransaction']),
        closeModal() {
            this.hideModal(this.id);
            this.memo = '';
            if (!this.$route.params.accountId) {
                    this.unSetCurrent();
                }
            // this.$refs.accountSelector.reset();
            // this.$refs.typeSelector.reset();
            // TODO: reset money?
            // TODO: reset TransactionSplitter/ TransactionTransfer?
        },
        saveNewTransaction() {
            let vm = this;
            let type = this.transactionType;

            // format split to contain negatives for withdrawals and the 'from' portion of the split
            let split = this.split
                .filter(item => item.amount > 0 && item.categoryId !== null)
                .map( (item, index) => {
                    // if type === 'deposit' do nothing
                    if (type === 'withdrawal') {
                        item.amount = -item.amount
                    } else if (type === 'transfer') {
                        item.amount = index === 0 ? -item.amount : item.amount;
                    }
                    return item;
                });

            let transaction = {
                accountId: this.currentAccount.id,
                type: this.transactionType,
                memo: this.memo,
                net_amount: this.netAmount,
                split: split,
                date: this.date
            }
            this.saveTransaction(transaction)
            .then( () => {
                if (vm.$route.params.accountId) {
                    vm.setCurrentById(vm.$route.params.accountId);
                }
                this.closeModal();
            }).catch( () => {

            });
        },
        onUpdateAccount(account) {
        },
        onUpdateType(type) {
            this.transactionType = type;
        },
        updateSplit(split) {
            this.split = split.map(row => ({
                amount: row.amount,
                category_id: row.category
                    ? row.category.id
                    : null
            }));
            if (this.transactionType == 'transfer') {
                this.netAmount = split[0].amount;
            } else {
                // remove js decimal errors with * 100 / 100
                this.netAmount = split.reduce( (sum, row) => sum + (row.amount * 100), 0)/100;
            }
        },
        handleMoneyChange(money) {
            if (money < 0 || money === -0) {
                this.netAmount = Math.abs(this.netAmount);
            }
        },
    },
    created() {},
    mounted() {},
    watch: {

    }
}
</script>

<style lang="scss">
#transaction-modal {
   .row {
        display: flex;
    }
    .grid-row {
        display: grid;
        grid-template-columns: 2fr 1fr;
        grid-gap: .5rem;
    }
    .v-money[disabled] {
        background: transparent;
        border: none;
    }
    label {
        margin-top: 1em;
    }
}
    
</style>
