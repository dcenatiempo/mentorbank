<template>
<modal  :id="id"
        :modal-title="modalTitle"
        :click-text="clickText"
        cancel-text="Cancel"
        @handle-modal-click="saveNewTransaction"
        @handle-modal-cancel="closeModal">
    
    <label>Date</label>
    <datepicker :value="date.__d" v-model="date"></datepicker>
    
    <label>Account</label>
    <account-selector ref="accountSelector" @select="onUpdateAccount"></account-selector>

    <label>Type</label>
    <transaction-type-selector ref="typeSelector" @select="onUpdateType"></transaction-type-selector>

    <template v-if="transactionType === 'transfer'">
        <transaction-transfer @split-updated="updateSplit">
        </transaction-transfer>
    </template>

    <template v-else>
        <transaction-splitter @split-updated="updateSplit">
        </transaction-splitter>
    </template>

    <label>Memo</label>
    <input type="text" placeholder="optional short descrition" v-model="memo">

</modal>
</template>

<script>
import {mapState, mapMutations, mapActions} from 'vuex';

import AccountSelector from '@reusable/AccountSelector.vue';
import TransactionTypeSelector from '@reusable/TransactionTypeSelector.vue';
import TransactionSplitter from '@reusable/TransactionSplitter.vue';
import TransactionTransfer from '@reusable/TransactionTransfer.vue';
import Modal from './Modal.vue';
import Datepicker from 'vuejs-datepicker';

export default {
    components: {
        Modal,
        AccountSelector,
        TransactionTypeSelector,
        Datepicker,
        TransactionSplitter,
        TransactionTransfer
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
            split: []
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
            let transaction = {
                accountId: this.account.accountId,
                type: this.transactionType,
                memo: this.memo,
                net_amount: this.netAmount,
                split: this.split,
                date: this.date
            }
            this.saveTransaction(transaction)
            .then( () => {
                this.closeModal();
            }).catch( () => {

            });
        },
        onUpdateAccount(account) {
            this.account = account;
        },
        onUpdateType(type) {
            this.transactionType = type;
        },
        updateSplit(split) {
            this.split = split.map(row => ({
                amount: row.amount,
                category_id: row.category_id
                    ? row.category_id.id
                    : null
            }));
            // remove js decimal errors with * 100 / 100
            this.netAmount = split.reduce( (sum, row) => sum + (row.amount * 100), 0)/100;
        }
    },
    created() {},
    mounted() {},
    watch: {}
}
</script>

<style scoped>
    .row {
        display: flex;
    }
    .grid-row {
        display: grid;
        grid-template-columns: 1fr 2fr;
        grid-gap: .5rem;
    }
</style>
