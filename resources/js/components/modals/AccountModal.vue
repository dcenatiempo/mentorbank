<template>
<modal  :id="id"
        :modal-title="modalTitle"
        :click-text="clickText"
        cancel-text="Cancel"
        @handle-modal-click="createNewAccount"
        @handle-modal-cancel="closeModal">

    <form v-on:submit.prevent>
        <label for="name">Name:</label>
        <input id="name" type="text" v-model="name"/>
        <label for="year">Birth Year:</label>
        <select v-model="year" id="year">
            <template v-for="y in years">
                <option :value="y" :key="y">{{y}}</option>
            </template>
        </select>
        <label for="month">Birth Month:</label>
        <select v-model="month" id="month">
            <template v-for="(m, index) in months">
                <option :value="index + 1" :key="m">{{m}}</option>
            </template>
        </select>
        <fieldset>
            <legend>Sex</legend>
            <input type="radio" id="m" value="m" v-model="sex">
            <label for="m">Male</label>
            <input type="radio" id="f" value="f" v-model="sex">
            <label for="f">Female</label>
        </fieldset>
    </form>

</modal>
</template>

<script>
import {mapState, mapActions, mapMutations} from 'vuex';

import Modal from './Modal.vue';

export default {
    components: {
        'modal': Modal,
    },
    props: {},
    data() {
        return {
            id: 'account-modal',
            name: '',
            year: null,
            month: null,
            sex: '',
            months: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
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
        years() {
            let years = [];
            let thisYear = new Date(Date.now()).getFullYear();
            for (let i = 0; i<18; i++ ) {
                years.push(thisYear--);
            }
            return years;
        }
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
                year: this.year,
                month: this.month,
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
