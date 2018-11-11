<template>
    <button v-on:click="openAddTransactionModal"><dollar height="50"></dollar></button>
</template>

<script>
import {mapState, mapGetters, mapActions, mapMutations} from 'vuex';
import CurrencyUsd from 'icons/CurrencyUsd';

export default {
    components: {
        'dollar': CurrencyUsd
    },
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
    mounted() {},
    watch: {}
}
</script>

<style lang='scss' scoped>
@import 'resources/sass/_variables.scss';

    button {
        position: fixed;
        bottom: 2rem;
        right: 2rem;
        border-radius: 2rem;
        background: $green;
        color: white;
        font-size: 0rem;
        height: 3rem;
        width: 3rem;
        line-height: 3rem;
        border: none;
        box-shadow: 1px 1px 4px 1px rgba(50, 50, 50, .3);

        svg {
            height: 36px;
            width: 36px;
        }
    }
</style>
