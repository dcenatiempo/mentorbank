<template>
    <button v-on:click="openAddTransactionModal">$</button>
</template>

<script>
import {mapState, mapGetters, mapActions, mapMutations} from 'vuex';

export default {
    components: {},
    props: {},
    data() {
        return {

        };
    },
    computed: {
        // ...mapState(),
        // ...mapGetters()
    },
    methods: {
        ...mapMutations('app', ['showModal']),
        // ...mapActions(),
        openAddTransactionModal() {
            this.showModal({
                modalId:'transaction-modal',
                payload: {mode: 'add'}
            });
        },
        
    },
    created() {},
    mounted() {
        console.log('AddTransactionBtn.vue mounted.')
    },
    watch: {}
}
</script>

<style scoped>
    button {
        position: fixed;
        bottom: 20px;
        right: 20px;
        border-radius: 50%;
        background: rgb(103, 146, 37);
        color: white;
    }
</style>
