<template>

    <section class="card-container">

        <div class="card">
            <h2>Balance: <currency :amount="currentAccount.balance"></currency></h2>            
        </div>

        <subscribed-categories></subscribed-categories>

    </section> 

</template>

<script>
import {mapState, mapGetters, mapActions, mapMutations} from 'vuex';
import SubscribedCategories from '@reusable/SubscribedCategories';
import Currency from '@reusable/Currency';

export default {
    components: {
        SubscribedCategories,
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
