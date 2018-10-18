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
        <label for="sex">Sex:</label>
        <div class="fieldset">
            <input type="radio" id="m" value="m" name="sex" v-model="sex">
            <label for="m">Male</label>
            <input type="radio" id="f" value="f" name="sex" v-model="sex">
            <label for="f">Female</label>
        </div>
    </form>

</modal>
</template>

<script>
import {mapState, mapActions, mapMutations} from 'vuex';
import Datepicker from 'vuejs-datepicker';

import Modal from './Modal.vue';

export default {
    components: {
        'modal': Modal,
        Datepicker,
    },
    props: {},
    data() {
        return {
            id: 'account-modal',
            name: '',
            sex: '',
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
                sex: this.sex
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
