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
    <account-selector ref="accountSelector" @select="onUpdateAccount"></account-selector>

    <label>Type</label>
    <div class="grid-row">
        <transaction-type-selector
            ref="typeSelector"
            @select="onUpdateType"></transaction-type-selector>
        <money
            v-bind="moneyConfig"
            v-model="netAmount"
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
            subedCats: [],
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
        mode() {
            let payload = this.modalPayload[this.id];
            return payload ? payload.mode : 'add';
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
            if (!this.account) return true;
            if (!this.transactionType) return true;
            if (this.split.find(item => item.category_id === null) !== undefined) return true;
            if (this.netAmount === 0) return true;
            return false;
        }
    },
    methods: {
        ...mapMutations('app', ['hideModal']),
        ...mapActions('transactions', ['saveTransaction']),
        closeModal() {
            this.hideModal(this.id);
            this.memo = '';
            this.$refs.accountSelector.reset();
            this.$refs.typeSelector.reset();
            // TODO: reset money?
            // TODO: reset TransactionSplitter/ TransactionTransfer?
        },
        saveNewTransaction() {
            let split = this.split.filter(item => item.amount > 0);
            let transaction = {
                accountId: this.account.accountId,
                type: this.transactionType,
                memo: this.memo,
                net_amount: this.netAmount,
                split: split,
                date: this.date
            }
            this.saveTransaction(transaction)
            .then( () => {
                this.closeModal();
            }).catch( () => {

            });
        },
        onUpdateAccount(account) {
            if (!account) return;
            this.account = account;
            axios.get(`/api/account/${account.accountId}/subscribed-category`)
            .then( res => {
                this.subedCats = res.data;
                this.subedCats.shift();
            })
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
        }
    },
    created() {},
    mounted() {},
    watch: {}
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
