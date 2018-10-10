<template>
    <modal>
        <h3>Example Modal Content</h3>
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

        };
    },
    computed: {
        ...mapState('user', ['name']),
        // ...mapGetters()
    },
    methods: {
        // ...mapMutations(),
        // ...mapActions(),
        
    },
    created() {},
    mounted() {
        console.log('ExampleModal.vue mounted.')
    },
    watch: {}
}
</script>

<style>

</style>
