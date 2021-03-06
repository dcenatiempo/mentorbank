<template>
<modal  :id="id"
        :modal-title="modalTitle"
        :click-text="clickText"
        cancel-text="Cancel"
        @handle-modal-click="saveCategory"
        @handle-modal-cancel="closeModal"
        :disabled="disabled">
    
    <label>Category Name</label>
    <input type="text" placeholder="enter unique category name" v-model="name">


    <div class="row">
        <label>Account Holders</label>
        <toggle-button
            v-model="forceSubscribe"
            :labels="{checked: 'All', unchecked: 'Pick'}"
            :color="{checked: '#41b883', unchecked: '#CCCCCC', disabled: '#CCCCCC'}"
            :width="70"
            :height="30"/>
    </div>

    <multiselect
        v-show="!forceSubscribe"
        v-model="selectedAccounts"
        :options="accountList"
        track-by="accountId"
        label="accountHolderName"
        placeholder="select account(s)"
        :preselect-first="isSingleAccount"
        :multiple="true"
        :allow-empty="true"
        :hideSelected="false"
        :value="preselectedAccount"
        @select="onSelectAccount">
    </multiselect>

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
            forceSubscribe: false,
            selectedAccounts: null,
            mode: 'add',
            category: null,
        };
    },
    computed: {
        ...mapState('app', ['modalPayload']),
        ...mapState(['accounts']),
        ...mapGetters('categories', ['getCategoryNames']),
        payload() {
            let payload = this.modalPayload[this.id];
            return payload ? payload : null;
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

            let catNames = this.category
                ? this.getCategoryNames.filter(name => name != this.category.name)
                : this.getCategoryNames;
            if (catNames.map(name => name.toLowerCase()).includes(this.name.trim().toLowerCase())) return true;

            return false;
        },
        // TODO: come up with a name/concept of Banks with 1 account vs Banks with 2+ accounts 
        isSingleAccount() {
            return this.accountList.length === 1;
        },
        preselectedAccount() {
            if (this.accounts.currentAccount.accountHolder.id) {
                return [{
                    accountHolderName: this.accounts.currentAccount.accountHolder.id,
                    accountId: this.accounts.currentAccount.accountHolder.name,

                }]
            }
        }

    },
    methods: {
        ...mapMutations('app', ['hideModal']),
        ...mapMutations('accounts', ['setCurrentById']),
        ...mapActions('categories', ['createCategory', 'updateCategory', 'fetchBankSubscribedCats']),
        closeModal() {
            this.hideModal(this.id);
            this.reset();
        },
        saveCategory() {
            // determine subscribed accounts
            let accountList = (this.forceSubscribe)
                ? this.accountList
                : this.selectedAccounts;

            let accountIds = accountList
                ? accountList.map(account => account.accountId)
                : null;

            let category = {
                name: this.name,
                forceSubscribe: this.forceSubscribe,
                subscribedIds: accountIds
            };
            if ('edit' == this.mode) {
                category.id = this.category.id;
                this.updateCategory(category).then( () => {
                    this.closeModal();
                }).catch( () => {});
            } else if ('add' == this.mode) {
                this.createCategory(category).then( () => {
                    this.closeModal();
                })
            }
            
        },
        onSelectAccount(value) {
            // let accountId = value ? value.accountId : null;
            // this.setCurrentById(accountId);
        },
        reset() {
            this.name = '';
            this.forceSubscribe = true;
            this.selectedAccounts = null;
        },
        getSubedAccounts(catId) {
            
            // get the subbed accounts for the "edit" modal
            return this.accounts.accountList.reduce((array, item) => {
                if (item.subscribedCategories.find(cat => cat.categoryId == catId)) {
                    array.push({
                        accountHolderName: item.accountHolder.name,
                        accountId: item.id
                    });
                }
                return array;
            }, []);
        }
    },
    created() {},
    mounted() {},
    watch: {
        payload (payload) {
            if (!payload) return;

            this.selectedAccounts = payload.currentAccount
                ? [{
                    accountHolderName: payload.currentAccount.accountHolder.name,
                    accountId: payload.currentAccount.id
                }]
                : [];

            this.mode = payload.mode ? payload.mode : 'add';

            this.forceSubscribe =  payload.currentAccount ? false : true;

            this.category = payload.category ? payload.category : null;

            if (this.category) {
                this.name = this.category.name;
                this.forceSubscribe = this.category.forceSubscribe;
                this.selectedAccounts = this.getSubedAccounts(this.category.id);
            }
        }
    }
}
</script>

<style lang="scss">
    #category-modal {
        .content {
            .row {
                display: flex;
                align-items: center;
                justify-content: space-between
            }
        }
    }
</style>

<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>