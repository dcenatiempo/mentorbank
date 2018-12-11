<template>
<modal  :id="id"
        modal-title="Edit Profile"
        click-text="Edit Profile"
        cancel-text="Cancel"
        @handle-modal-click="saveProfile"
        @handle-modal-cancel="closeModal">

    <form v-on:submit.prevent>
        <label for="name">Name:</label>
        <input disabled id="name" type="text" placeholder="Account holder's name" v-model="name"/>
        <label for="email">Email:</label>
        <input disabled id="email" type="text" placeholder="Account holder's name" v-model="email"/>
        <label for="pin">Pin:</label>
        <input id="pin" type="text" placeholder="4+ character pin" v-model="pin"/>
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
            id: 'profile-modal',
            mode: 'edit',
            name: '',
            email: '',
            pin: '',
            userId: ''
        };
    },
    computed: {
        ...mapState('app', ['modalPayload']),
        payload() {
            let payload = this.modalPayload[this.id];
            return payload ? payload : null;
        },
    },
    methods: {
        ...mapMutations('app', ['hideModal']),
        ...mapActions('user', ['updateUser']),
        closeModal() {
            this.hideModal(this.id);
            this.reset();
        },
        reset() {
            this.name = '';
            this.email = '';
            this.pin = '';
        },
        saveProfile() {
            let vm = this;
            let user = {
                // name: this.name,
                // email: this.email,
                pin: this.pin
            }

            // accountHolder.id = this.acccountHolderId;
            this.updateUser(user)
                .then( () => vm.closeModal())
                .catch( () => {});
        },
    },
    created() {},
    mounted() {},
    watch: {
        payload (payload) {
            if (!payload) return;

            if (payload.user) {
                this.name = payload.user.name;
                this.email = payload.user.email;
                this.pin = payload.user.pin;
                this.userId = payload.user.userId;
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
</style>
