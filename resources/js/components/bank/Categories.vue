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
// import DeleteIcon from 'icons/Delete';


export default {
    components: {
        Vuetable
    },
    props: {},
    data() {
        return {
                columns: [ {
                        name: '__checkbox',
                        title: 'Select',
                        width: '50px'
                    },{
                        name: 'name',
                        sortField: 'name'
                    },{
                        name: 'is_global',
                        title: 'Global',
                        callback: this.formatBool,
                        visible: false
                    },{
                        name: 'notifications',
                        callback: this.formatBool
                    },{
                        name: 'force_subscribe',
                        title: 'Bank Global',
                        callback: this.formatBool
                    },{
                        name: '__component:delete-icon',
                        title: 'delete'
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
