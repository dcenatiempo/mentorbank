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
import VuetableFieldActions from '@reusable/VuetableFieldActions';


export default {

    components: {
        Vuetable,
        VuetableFieldActions
    },
    props: {},
    data() {
        return {
                columns: [
                    {
                        name: 'name',
                        sortField: 'name'
                    },{
                        name: 'notifications',
                        formatter: this.formatBool
                    },{
                        name: 'forceSubscribe',
                        title: 'AutoSub',
                        formatter: this.formatBool
                    },{
                        name: 'subscribedCount',
                        title: '# of Accounts'
                    },{
                        name: 'deletedAt',
                        title: 'Archived'
                    },{
                        name: VuetableFieldActions,
                    }
                ],
        };
    },
    computed: {
        ...mapState('categories', ['categoryList', 'loading']),
    },
    methods: {
        ...mapActions('categories', ['fetchAllCategories']),
        formatBool (val) {
            return val === true ? '✔' : '';
            // return val ? `<input type="checkbox" checked disabled>` : `<input type="checkbox" disabled>`;
        }
    },
    created() {
        if (0 == this.categoryList.length) {
            this.fetchAllCategories();
        }
    },
    mounted() {
    },
    watch: {}
}
</script>

<style>

</style>
