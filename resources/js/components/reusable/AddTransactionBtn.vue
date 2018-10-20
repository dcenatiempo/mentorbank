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

<style lang='scss' scoped>
@import 'resources/sass/_variables.scss';

    button {
        position: fixed;
        bottom: 2rem;
        right: 2rem;
        border-radius: 50%;
        background: $green;
        color: white;
        font-size: 2rem;
        height: 3rem;
        width: 3rem;
        line-height: 3rem;
        border: none;
        box-shadow: 1px 1px 4px 1px rgba(50, 50, 50, .3);
    }
</style>
