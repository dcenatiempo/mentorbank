<template>
    <div class="container">
        <h2>Transaction Page</h2>
        <vuetable ref="vuetable"
            :fields="columns"
            :api-mode="false"
            :data="transactionList"></vuetable>
    </div>
</template>

<script>
import {mapState, mapGetters, mapActions, mapMutations} from 'vuex';
import Vuetable from 'vuetable-2/src/components/Vuetable';

export default {
    components: {
        Vuetable
    },
    props: {},
    data() {
        return {
                columns: [ {
                        name: 'date'
                    },{
                        name: 'memo'
                    },{
                        name: 'net_amount'
                    },{
                        name: 'type'
                    }
                ],
        };
    },
    computed: {
        ...mapState('transactions', ['transactionList', 'loading']),
    },
    methods: {
        ...mapMutations('app', ['popPageHistory']),
        // ...mapActions(),
        formatBool (val) {
            // return val ? 'Yes' : 'No';
            return val ? `<input type="checkbox" checked disabled>` : `<input type="checkbox" disabled>`;
        }
    },
    created() {},
    mounted() {},
    watch: {}
}
</script>

<style>

</style>
