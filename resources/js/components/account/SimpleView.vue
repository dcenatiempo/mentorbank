<template>

    <section class="card-container">

        <div class="card">
            <h2>Balance: <currency :amount="currentAccount.balance"></currency></h2>            
        </div>

        <div class="card">
            <h2 class="card-header">Categories</h2>
            <template v-for="category in subedCats">
                <div :key="'c-'+category.id">
                    <h3>{{getCategoryName(category.categoryId)}} <currency :amount="category.balance"></currency></h3>
                </div>
            </template>
        </div>

    </section> 

</template>

<script>
import {mapState, mapGetters, mapActions, mapMutations} from 'vuex';
import Currency from '@reusable/Currency';

export default {
    components: {
        Currency,
    },
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
        getCategoryName(id) {
            if (this.categoryList.length == 0) return '';
            let name = this.categoryList.find( cat => cat.id == id).name;
            return name;
        },
    },
    created() {},
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
