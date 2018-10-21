<template>
    <div class="container">
        <h2>Category Page</h2>
        <vuetable ref="vuetable"
            :fields="columns"
            :api-mode="false"
            :data="categoryList"></vuetable>
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
                        name: 'is_global',
                        callback: this.formatBool
                    },{
                        name: 'notifications',
                        callback: this.formatBool
                    }
                ],
        };
    },
    computed: {
        ...mapState('categories', ['categoryList', 'loading']),
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
