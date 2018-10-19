<template>
<div>
    <div class="grid-row">
            <label>Amount</label> <label>Category</label>
        </div>
        <div class="grid-row">
            <money ref="money" @change="onUpdateMoney"></money>
            <category-selector ref="categorySelector" @select="onUpdateCategory"></category-selector>
            <money ref="money" @change="onUpdateMoney"></money>
            <category-selector ref="categorySelector" @select="onUpdateCategory"></category-selector>
            <money ref="money" @change="onUpdateMoney"></money>
            <category-selector ref="categorySelector" @select="onUpdateCategory"></category-selector>
        </div>
        <div><a>+ Add Category</a></div>
</div>
</template>

<script>
import {mapState, mapGetters, mapActions, mapMutations} from 'vuex';
import CategorySelector from '../reusable/CategorySelector.vue';
import Money from '../reusable/Money.vue';

export default {
    components: {
        CategorySelector,
        Money
    },
    props: {},
    data() {
        return {
        };
    },
    computed: {
        // ...mapState(),
        // ...mapGetters()
    },
    methods: {
        // ...mapMutations(),
        // ...mapActions(),
        onUpdateMoney(money) {
            // this.amount = money;
        },
        onUpdateCategory(cat) {
            // this.category = cat;
        }      
    },
    created() {},
    mounted() {
    },
    watch: {}
}
</script>

<style>
    .row {
        display: flex;
    }
    .grid-row {
        display: grid;
        grid-template-columns: 1fr 2fr;
        grid-gap: .5rem;
    }
</style>
