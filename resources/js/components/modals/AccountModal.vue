<template>
<modal  :id="id"
        :modal-title="modalTitle"
        :click-text="clickText"
        cancel-text="Cancel"
        @handle-modal-click="createNewAccount"
        @handle-modal-cancel="closeModal">

    <form v-on:submit.prevent>
        <label for="name">Name:</label>
        <input id="name" type="text" placeholder="Enter account holder's name" v-model="name"/>
        <label for="year">Birth Month:</label>
        <datepicker :format="'MMM yyyy'" :minimumView="'month'" :maximumView="'month'" v-model="birthDate"></datepicker>
        <toggle-button
            v-model="isMale"
            :labels="{checked: 'Male', unchecked: 'Female'}"
            :color="{checked: '#6cb2eb', unchecked: 'pink', disabled: '#CCCCCC'}"
            :width="70"
            :height="30"/>
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
            name: '',
            isMale: true,
            birthDate: moment().subtract(5, 'year').format(),
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
            return this.mode + ' account'
        },
    },
    methods: {
        ...mapMutations('app', ['hideModal']),
        ...mapActions('accounts', ['createAccount']),
        closeModal() {
            this.hideModal(this.id);
            this.name = '';
        },
        createNewAccount() {
            let vm = this;
            let account = {
                name: this.name,
                birthDate: this.birthDate,
                sex: this.isMale ? 'm' : 'f'
            }
            console.dir(account)
            this.createAccount(account)
            .then(() => vm.closeModal())
            .catch((error) => {
                
            });;
        },
    },
    created() {},
    mounted() {},
    watch: {}
}
</script>

<style>

</style>
