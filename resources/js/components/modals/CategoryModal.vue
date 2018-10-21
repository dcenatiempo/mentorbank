<template>
<modal  :id="id"
        :modal-title="modalTitle"
        :click-text="clickText"
        cancel-text="Cancel"
        @handle-modal-click="saveCategory"
        @handle-modal-cancel="closeModal"
        :disabled="disabled">
    
    <label>Name</label>
    <input type="text" placeholder="enter category name" v-model="name">


    <template v-if="accountList.length > 1">
        <label>Standard</label>
        <toggle-button v-model="standard"/>

        <template v-if="!standard">
            <multiselect
                v-model="selectedAccounts"
                :options="accountList"
                track-by="accountId"
                label="accountHolderName"
                placeholder="select an account"
                :preselect-first="true"
                :multiple="true"
                :allow-empty="false"
                :hideSelected="false"
                @select="onSelectAccount">
            </multiselect>
        </template>
    </template>

    <!-- <label>Notifications</label>
    <input type="checkbox" v-model="notifications">

    <label>Archive</label>
    <input type="checkbox" v-model="archived"> -->


</modal>
</template>

<script>
import {mapState, mapGetters, mapMutations, mapActions} from 'vuex';
import ToggleButton from 'vue-js-toggle-button/src/Button';
import Multiselect from 'vue-multiselect';

import Modal from './Modal.vue';

export default {
    components: {
        Modal,
        Multiselect,
        ToggleButton
    },
    props: {},
    data() {
        return {
            id: 'category-modal',
            name: '',
            standard: false,
            selectedAccounts: null,
        };
    },
    computed: {
        ...mapState('app', ['modalPayload']),
        ...mapState(['accounts']),
        ...mapGetters('categories', ['getCategoryNames']),
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
            return this.mode + ' category'
        },
        accountList() {
            return this.accounts.accountList.map(item => (
                {
                    accountHolderName: item.accountHolder.name,
                    accountId: item.id
                }
            ));
        },
        disabled() {
            if (this.name.length < 1) return true;
            if (this.getCategoryNames.includes(this.name.trim())) return true;
            return false;
        }
    },
    methods: {
        ...mapMutations('app', ['hideModal']),
        ...mapMutations('accounts', ['setCurrentById']),
        ...mapActions('categories', ['createCategory']),
        closeModal() {
            this.hideModal(this.id);
            this.name = '';
        },
        saveCategory() {
            let category = {
                name: this.name,
                standard: this.standard
            };

            this.createCategory(category).then( () => {
                this.closeModal();
            }).catch( () => {

            });
        },
        onSelectAccount(value) {
            let accountId = value ? value.accountId : null;
            this.setCurrentById(accountId);
        },
    },
    created() {},
    mounted() {},
    watch: {}
}
</script>

<style>

</style>

<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>