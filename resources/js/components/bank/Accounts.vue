<template>
    <div class="container">
        <button v-on:click="$router.go(-1)">&lt;</button>
        <h2>Account Page</h2>
        <vuetable ref="vuetable"
            :fields="columns"
            :api-mode="false"
            :data="accountData"></vuetable>
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
                name: 'name'
            },{
                name: 'balance'
            },
            ],
        };
    },
    computed: {
        ...mapState('accounts', ['accountList', 'loading']),
        accountData() {
            return this.accountList.map( account => (
                {
                    'name': account.accountHolder.name,
                    'balance': account.balance
                }
            ))
        }
    },
    methods: {
        // ...mapMutations(),
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
