<template>
<modal  :id="id"
        :modal-title="modalTitle"
        :click-text="clickText"
        cancel-text="Cancel"
        @handle-modal-click="closeModal"
        @handle-modal-cancel="closeModal">
    
    <!--
    account/account holder
    memo
    type (withdrawal, deposit, transfer)
    ammount
    category
    {split: category/ammount}
    -->
    <label>Account</label>
    <account-selector></account-selector>

    <label>Memo</label>
    <input type="text">

    <label>Ammount</label>
    <input type="number">

    <label>Category</label>
    <category-selector></category-selector>

</modal>
</template>

<script>
import {mapState, mapGetters, mapActions, mapMutations} from 'vuex';
import Modal from './Modal.vue';

export default {
    components: {
        'modal': Modal,
    },
    props: {},
    data() {
        return {
            id: 'transaction-modal'
        };
    },
    computed: {
        ...mapState('app', ['modalPayload']),
        // ...mapGetters()
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
            if (this.mode === 'add') {
                return 'Add Transaction'
            } else if (this.mode == 'edit') {
                return 'Edit Transaction'
            }
            return 'Transaction';
        }
    },
    methods: {
        ...mapMutations('app', ['hideModal']),
        // ...mapActions(),
        closeModal() {
            this.hideModal(this.id);
        }
        
    },
    created() {
        
    },
    mounted() {
        console.log('TransactionModal.vue mounted.')
    },
    watch: {}
}
</script>

<style>

</style>
