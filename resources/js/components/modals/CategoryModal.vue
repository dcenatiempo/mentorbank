<template>
<modal  :id="id"
        :modal-title="modalTitle"
        :click-text="clickText"
        cancel-text="Cancel"
        @handle-modal-click="saveCategory"
        @handle-modal-cancel="closeModal">
    
    <label>Name</label>
    <input type="text" placeholder="enter category name" v-model="name">

    <label>Standard</label>
    <input type="checkbox" v-model="standard">

    <!-- <label>Notifications</label>
    <input type="checkbox" v-model="notifications">

    <label>Archive</label>
    <input type="checkbox" v-model="archived"> -->


</modal>
</template>

<script>
import {mapState, mapMutations} from 'vuex';

import Modal from './Modal.vue';

export default {
    components: {
        'modal': Modal,
    },
    props: {},
    data() {
        return {
            id: 'category-modal',
            name: '',
            standard: false
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
            return this.mode + ' category'
        }
    },
    methods: {
        ...mapMutations('app', ['hideModal']),
        closeModal() {
            this.hideModal(this.id);
            this.name = '';
        },
        saveCategory() {
            let category = {
                name: this.name,
                standard: this.standard
            };

            axios.post(`/api/bank/category`, category)
            .then( result => {
                console.log(result);
            }).catch( err => {
                console.error(err);
            });
        }
    },
    created() {},
    mounted() {},
    watch: {}
}
</script>

<style>

</style>
