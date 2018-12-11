<template>
<modal  :id="id"
        :modal-title="modalTitle"
        :click-text="clickText"
        cancel-text="Cancel"
        @handle-modal-click="saveAccount"
        @handle-modal-cancel="closeModal">

    <form v-on:submit.prevent>
        <label for="name">Name:</label>
        <input id="name" type="text" placeholder="Account holder's name" v-model="name"/>
        <label for="year">Birth Month:</label>
        <datepicker id="year" :format="'MMM yyyy'" :minimumView="'month'" :maximumView="'month'" v-model="birthdate" :use-utc="true"></datepicker>
        <label>Sex:</label>
        <div><toggle-button
            v-model="isMale"
            :labels="{checked: 'Male', unchecked: 'Female'}"
            :color="{checked: '#6cb2eb', unchecked: 'pink', disabled: '#CCCCCC'}"
            :width="75"
            :height="30"/>
        </div>
        <label for="pin">Pin:</label>
        <input id="pin" type="text" placeholder="4+ character pin" v-model="pin"/>
    </form>

</modal>
</template>

<script>
import {mapState, mapActions, mapMutations} from 'vuex';
import Datepicker from 'vuejs-datepicker';
import ToggleButton from 'vue-js-toggle-button/src/Button';

import Modal from './Modal.vue';

export default {
    components: {
        'modal': Modal,
        Datepicker,
        ToggleButton
    },
    props: {},
    data() {
        return {
            id: 'account-modal',
            mode: 'add',
            name: '',
            isMale: true,
            birthdate: moment().subtract(5, 'year').format("YYYY-MM-DD"),
            pin: ''
        };
    },
    computed: {
        ...mapState('app', ['modalPayload']),
        clickText() {
            if (this.mode === 'add') {
                return 'Add New'
            } else if (this.mode == 'edit') {
                return 'Save Changes'
            }
            return 'Close';
        },
        modalTitle() {
            return this.mode + ' account'
        },
        payload() {
            let payload = this.modalPayload[this.id];
            return payload ? payload : null;
        },
    },
    methods: {
        ...mapMutations('app', ['hideModal']),
        ...mapActions('accounts', ['createAccount', 'updateAccountHolder']),
        closeModal() {
            this.hideModal(this.id);
            this.reset();
        },
        reset() {
            this.name = '';
            this.isMale = true;
            this.birthdate = moment().subtract(5, 'year').format();
            this.pin = '';
        },
        saveAccount() {
            let vm = this;
            let accountHolder = {
                name: this.name,
                birthdate: moment.utc(this.birthdate).format("YYYY-MM-DD"),
                sex: this.isMale ? 'm' : 'f',
                pin: this.pin
            }

            if ('edit' == this.mode) {
                accountHolder.id = this.acccountHolderId;
                this.updateAccountHolder(accountHolder)
                    .then( () => vm.closeModal())
                    .catch( () => {});

            } else if ('add' == this.mode) {

                this.createAccount(accountHolder)
                    .then(() => vm.closeModal())
                    .catch( () => {});
            }
        },
    },
    created() {},
    mounted() {},
    watch: {
        payload (payload) {
            if (!payload) return;

            this.mode = payload.mode ? payload.mode : 'add';

            if (payload.accountHolder) {
                this.name = payload.accountHolder.name;
                this.isMale = 'm' == payload.accountHolder.sex ? true : false;
                this.birthdate = moment.utc(payload.accountHolder.birthdate).format('YYYY-MM-DD');
                this.pin = payload.accountHolder.pin;
                this.acccountHolderId = payload.accountHolder.id;
            }
        },
    }
}
</script>

<style scoped lang="scss">
form {
    display: grid;
    grid-template-columns: max-content 1fr;
    grid-column-gap: 1rem;

    label {
        text-align: right;
    }
}

</style>

<style>
    .vdp-datepicker__calendar {
        left: -116px;
    }
</style>
