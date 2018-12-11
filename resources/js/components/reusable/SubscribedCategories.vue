<template>

    <div class="card">
        <h2 class="card-header">Categories<button v-on:click="showCategoryModal" class="btn-icon">+</button></h2>
        <div class="category-grid">
            <template v-for="category in subedCats">
            <button :key="'sc1-'+category.id" v-on:click="showAccountCategoryModal(category)" class="cat-name btn-link">{{getCategoryName(category.categoryId)}}</button>
            <currency :key="'sc2-'+category.id" :amount="category.balance"></currency>
            <goal-meter :key="'sc3-'+category.id" :goal="category.goalBalance" :balance="category.balance"></goal-meter>
            </template>
        </div>
    </div>

</template>

<script>
import {mapState, mapGetters, mapActions, mapMutations} from 'vuex';
import Currency from '@reusable/Currency';
import GoalMeter from '@reusable/GoalMeter';
import Pencil from 'icons/pencil';

export default {
    components: {
        Currency,
        GoalMeter,
        'edit': Pencil
    },
    props: {},
    data() {
        return {
        };
    },
    computed: {
        ...mapState('categories', ['categoryList']),
        ...mapState('accounts', ['currentAccount']),
        ...mapGetters('accounts', { 'subedCats': 'accountSubedCats'}),
    },
    methods: {
        ...mapMutations('app', ['showModal', 'hideModal']),
        ...mapActions('categories', ['fetchAllCategories']),
        showCategoryModal() {
            this.showModal({
                modalId: 'category-modal',
                payload: {
                    mode: "add",
                    currentAccount: this.currentAccount
                }
            });
        },
        showAccountCategoryModal(subCat) {
            this.showModal({
                modalId: 'account-category-modal',
                payload: {
                    mode: "edit",
                    subscribedCategory: subCat,
                    category: this.categoryList.find(cat => cat.id == subCat.categoryId)
                }
            });
        },
        getCategoryName(id) {
            if (this.categoryList.length == 0) return '';
            let name = this.categoryList.find( cat => cat.id == id).name;
            return name;
        },
    },
    created() {
        if (this.categoryList.length == 0) {
            this.fetchAllCategories();
        }
    },
    mounted() {
        
    },
    watch: {
    }
}
</script>

<style lang="scss">
#dashboard {
    display: grid;
    grid-gap: 1rem;
    
    .row {
        display: flex;
        align-content: center;
    }
    .category-grid {
        display: grid;
        grid-template-columns: minmax(auto, max-content) max-content minmax(80px, 1fr);
        font-size: 1.8em;
        justify-items: end;
        align-items: center;
        grid-column-gap: 8%;

        .cat-name {
            max-width: 100%;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            justify-self: start;
            text-align: left
        }
    }

    .top-section {
        background: white;
        grid-column: 1 / end;
        padding: 1rem;
    }

    .card-container {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
        grid-gap: 1rem;

        .card {
            padding: 1rem;
            background: white;

            .card-header {
                display: flex;
                justify-content: space-between;
            }
        }
    }
    
}
    
</style>
