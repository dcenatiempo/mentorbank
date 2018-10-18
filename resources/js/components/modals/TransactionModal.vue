<template>
<modal  :id="id"
        :modal-title="modalTitle"
        :click-text="clickText"
        cancel-text="Cancel"
        @handle-modal-click="saveNewTransaction"
        @handle-modal-cancel="closeModal">
    
    <label>Account</label>
    <account-selector ref="accountSelector" @select="onUpdateAccount"></account-selector>

    <label>Type</label>
    <transaction-type-selector ref="typeSelector" @select="onUpdateType"></transaction-type-selector>

    <label>Memo</label>
    <input type="text" placeholder="optional short descrition" v-model="memo">

    <label>Amount</label>
    <money ref="money" @change="onUpdateMoney"></money>

    <label>Category</label>
    <category-selector ref="categorySelector" @select="onUpdateCategory"></category-selector>

    <label>Date</label>
    <datepicker :value="date.__d" v-model="date"></datepicker>

</modal>
</template>

<script>
import {mapState, mapMutations, mapActions} from 'vuex';

import Money from '../reusable/Money.vue';
import AccountSelector from '../reusable/AccountSelector.vue';
import CategorySelector from '../reusable/CategorySelector.vue';
import TransactionTypeSelector from '../reusable/TransactionTypeSelector.vue';
import Modal from './Modal.vue';
import Datepicker from 'vuejs-datepicker';

export default {
    components: {
        'modal': Modal,
        'category-selector': CategorySelector,
        'account-selector': AccountSelector,
        'transaction-type-selector': TransactionTypeSelector,
        'money': Money,
        Datepicker
    },
    props: {},
    data() {
        return {
            id: 'transaction-modal',
            account: null,
            transactionType: null,
            memo: '',
            amount: 0,
            category: null,
            date: moment().format()
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
            this.$refs.money.reset();
            this.$refs.accountSelector.reset();
            this.$refs.categorySelector.reset();
            this.$refs.typeSelector.reset();
        },
        saveNewTransaction() {
            let transaction = {
                accountId: this.account.accountId,
                type: this.transactionType,
                memo: this.memo,
                amount: this.amount,
                split: {
                    categoryId: this.category.id,
                    amount: this.amount
                },
                date: this.date
            }
            this.saveTransaction(transaction)
            .then( () => {
                this.closeModal();
            }).catch( () => {

            });
        },
        onUpdateMoney(money) {
            this.amount = money;
        },
        onUpdateAccount(account) {
            this.account = account;
        },
        onUpdateType(type) {
            this.transactionType = type;
        },
        onUpdateCategory(cat) {
            this.category = cat;
        }
    },
    created() {},
    mounted() {},
    watch: {}
}
</script>

<style>

</style>
