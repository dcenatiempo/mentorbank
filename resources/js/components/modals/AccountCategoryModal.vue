<template>

<modal  :id="id"
        :modal-title="modalTitle"
        :click-text="clickText"
        cancel-text="Cancel"
        @handle-modal-click="saveCategory"
        @handle-modal-cancel="closeModal"
        :disabled="disabled">
    
    <template v-if="!simple">
        <label>Notifications</label>
        <div><toggle-button
                v-model="notifications"
                :labels="{checked: 'On', unchecked: 'Off'}"
                :color="{checked: '#41b883', unchecked: 'rgb(160, 165, 175)', disabled: '#CCCCCC'}"
                :width="70"
                :height="30"/>
        </div>
     </template>
            
    <label>Goal Balance</label>
    <money
            v-bind="moneyConfig"
            v-model="goalBalance"
            @input="handleMoneyChange"
            :disabled="false"></money>
    
    <template v-if="!simple">
        <label>Low Balance Alert</label>
        <money
                v-bind="moneyConfig"
                v-model="lowBalanceAlert"
                @input="handleMoneyChange"
                :disabled="!notifications"></money>
    </template>

    <!-- <div class="row">
        <label>Account Holders</label>
        <toggle-button
            v-model="forceSubscribe"
            :labels="{checked: 'All', unchecked: 'Pick'}"
            :color="{checked: '#41b883', unchecked: '#CCCCCC', disabled: '#CCCCCC'}"
            :width="70"
            :height="30"/>
    </div> -->

    <!-- <multiselect
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
    </multiselect> -->

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
import {Money} from 'v-money';

import Modal from './Modal.vue';

export default {
    components: {
        Modal,
        Multiselect,
        ToggleButton,
        Money
    },
    props: {},
    data() {
        return {
            id: 'account-category-modal',
            mode: '',
            simple: false,
            name: '',
            balance: 0,
            goalBalance: 0,
            notifications: false,
            lowBalanceAlert: 0,
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
        // ...mapState(['accounts']),
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
            return `${this.mode} ${this.name} Category`;
        },
        disabled() {
            // if (this.name.length < 1) return true;

            // let catNames = this.category
            //     ? this.getCategoryNames.filter(name => name != this.category.name)
            //     : this.getCategoryNames;
            // if (catNames.map(name => name.toLowerCase()).includes(this.name.trim().toLowerCase())) return true;

            return false;
        },

    },
    methods: {
        ...mapMutations('app', ['hideModal']),
        ...mapActions('categories', ['updateSubscribedCategory']),
        closeModal() {
            this.hideModal(this.id);
            this.reset();
        },
        saveCategory() {
            let accountId = this.payload.subscribedCategory.accountId;
            let subscribedCategory = {
                id: this.payload.subscribedCategory.id,
                goal_balance: this.goalBalance,
                low_balance_alert: this.lowBalanceAlert,
                notifications: this.notifications
            };

            this.updateSubscribedCategory({accountId, subscribedCategory}).then( () => {
                this.closeModal();
            }).catch( () => {});
        },
        handleMoneyChange(amount) {
            if (this.goalBalance < 0)
                this.goalBalance = 0;
            if (this.lowBalanceAlert < 0)
                this.lowBalanceAlert = 0;
        },
        reset() {
            this.mode = '';
            this.category = null;
            this.subscribedCategory = null;
        },
    },
    created() {},
    mounted() {},
    watch: {
        payload (payload) {
            if (!payload) return;

            this.mode = payload.mode ? payload.mode : 'edit';
            this.simple = payload.simple ? payload.simple : false;
            if (payload.category && payload.subscribedCategory) {
                this.name = payload.category.name;
                this.balance = payload.subscribedCategory.balance;
                this.goalBalance = payload.subscribedCategory.goalBalance ? payload.subscribedCategory.goalBalance : 0;
                this.notifications = payload.subscribedCategory.notifications;
                this.lowBalanceAlert = payload.subscribedCategory.lowBalanceAlert;
            }
        }
    }
}
</script>

<style lang="scss">
@import 'resources/sass/_variables.scss';

    #account-category-modal {
        .content {
            display: grid;
            grid-template-columns: 1fr 1fr;
            justify-items: end;
            grid-column-gap: 1rem;

            :nth-child(even) {
                justify-self: center;
            }

            .v-money[disabled] {
                color: $gray;
                background: transparent;
                border-color: transparent;
            }
        } 
    }
</style>