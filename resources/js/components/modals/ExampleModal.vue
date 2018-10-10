<template>
    <modal  :id="id"
            modal-title="Example Modal Title"
            click-text="Submit"
            cancel-text="Abort"
            @handle-modal-click="closeModal"
            @handle-modal-cancel="closeModal">
        <h3>Example Modal Content</h3>
        <h2>{{message}}</h2>
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
            id: 'example-modal'
        };
    },
    computed: {
        ...mapState('user', ['name']),
        ...mapState('app', ['modalPayload']),
        // ...mapGetters()
        message() {
            let payload = this.modalPayload[this.id];
            return payload ? payload.message : '';
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
        console.log('ExampleModal.vue mounted.')
    },
    watch: {}
}
</script>

<style>

</style>
