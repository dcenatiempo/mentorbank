<template>
    <div class="container">
        <button v-on:click="$router.go(-1)">&lt;</button>
        <h2>Account Page</h2>
        <vuetable ref="vuetable"
            :fields="columns"
            :api-mode="false"
            :data="accountList"></vuetable>
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
                    },
                ],
        };
    },
    computed: {
        ...mapState('accounts', ['accountList', 'loading']),
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
    mounted() {
        console.log('Accounts.vue mounted.')
    },
    watch: {}
}
</script>

<style>

</style>
