<template>

    <th v-if="isHeader">
        Actions
    </th>

    <td v-else-if="!rowData.isGlobal">
        <button v-on:click="showCategoryModal" class="btn-icon"><edit></edit></button>
        <button v-on:click="deleteCat" class="btn-icon"><delete></delete></button>
    </td>

</template>

<script>
import VuetableFieldMixin from 'vuetable-2/src/components/VuetableFieldMixin';
import {mapState, mapGetters, mapActions, mapMutations} from 'vuex';
import Pencil from 'icons/pencil';
import Delete from 'icons/delete';

export default {
    name: 'vuetable-field-actions',
    mixins: [VuetableFieldMixin],
    components: {
        'edit': Pencil,
        'delete' : Delete
    },
    props: {
        
    },
    data() {
        return {

        };
    },
    computed: {
    },
    methods: {
        ...mapMutations('app', ['showModal', 'hideModal']),
        ...mapActions('categories', ['deleteCategory']),
        showCategoryModal() {
            this.showModal({
                modalId: 'category-modal',
                payload: {
                    mode: "edit",
                    category: this.rowData
                }
            });
        },
        deleteCat() {
            // alert(`deleting ${this.rowData.name} category (id: ${this.rowData.id})`);
            this.deleteCategory(this.rowData.id);
        }
        
    },
    created() {},
    mounted() {},
    watch: {}
}
</script>

<style>

</style>
