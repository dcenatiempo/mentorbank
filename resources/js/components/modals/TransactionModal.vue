<template>
<modal  :id="id"
        :modal-title="modalTitle"
        :click-text="clickText"
        cancel-text="Cancel"
        @handle-modal-click="saveTransaction"
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

</modal>
</template>

<script>
import {mapState, mapMutations} from 'vuex';

import Money from '../reusable/Money.vue';
import AccountSelector from '../reusable/AccountSelector.vue';
import CategorySelector from '../reusable/CategorySelector.vue';
import TransactionTypeSelector from '../reusable/TransactionTypeSelector.vue';
import Modal from './Modal.vue';

export default {
    components: {
        'modal': Modal,
        'category-selector': CategorySelector,
        'account-selector': AccountSelector,
        'transaction-type-selector': TransactionTypeSelector,
        'money': Money
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
        closeModal() {
            this.hideModal(this.id);
            this.memo = '';
            this.$refs.money.reset();
            this.$refs.accountSelector.reset();
            this.$refs.categorySelector.reset();
            this.$refs.typeSelector.reset();
        },
        saveTransaction() {
            debugger
            let transaction = {
                accountId: this.account.accountId,
                type: this.transactionType,
                memo: this.memo,
                amount: this.amount,
                split: {
                    categoryId: this.category.id,
                    amount: this.amount
                }
            }
            axios.post(`/api/account/${this.account.accountId}/transaction`, transaction)
            .then( result => {
                console.log(result);
            }).catch( err => {
                console.error(err);
            })
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