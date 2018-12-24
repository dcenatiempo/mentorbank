<template>
    <div class="container">
        <h2>
            Category Page
            <button
                v-if="canAddCats"
                v-on:click="showCategoryModal"
                class="btn-icon">+</button>
        </h2>
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
        let vm = this;
        return {
                columns: [
                    {
                        name: 'name',
                        sortField: 'name'
                    },{
                        name: 'notifications',
                        formatter: this.formatBool,
                        visible: false
                    },{
                        name: 'forceSubscribe',
                        title: 'Auto-sub',
                        formatter: this.formatBool
                    },{
                        name: 'subscribedCount',
                        title: '# of Accounts',
                        formatter(val) {
                            if (null == val) {
                                return vm.accountListCount
                            }
                            return val;
                        }
                    },{
                        name: 'deletedAt',
                        title: 'Archived',
                        visible: false
                    },{
                        name: VuetableFieldActions,
                    }
                ],
        };
    },
    computed: {
        ...mapState('categories', ['categoryList', 'loading']),
        ...mapGetters('accounts', ['accountListCount']),
        ...mapState('bank', ['planType']),
        canAddCats() {
            // Remove this when stripe implemented //
            return true; ////////////////////////////
            /////////////////////////////////////////
            //return 'paid' == this.planType || this.categoryList.length < 5;
        }
    },
    methods: {
        ...mapActions('categories', ['fetchAllCategories']),
         ...mapMutations('app', ['showModal', 'hideModal']),
        formatBool (val) {
            return val === true ? '✔' : '';
            // return val ? `<input type="checkbox" checked disabled>` : `<input type="checkbox" disabled>`;
        },
        showCategoryModal() {
            this.showModal({
                modalId: 'category-modal',
                payload: {mode: "add"}
            });
        },
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

<style lang="scss">
    .vuetable-td-forceSubscribe {
        color: green;
        text-align: center;
    }
    .vuetable-td-subscribedCount {
        text-align: center;
    }
</style>
