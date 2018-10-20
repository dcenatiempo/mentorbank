<template>
<div>
    <label>Amount</label>
    <money ref="money" @change="onUpdateMoney"></money>

    <div class="grid-row">
        <label>From</label><label>To</label>
        <category-selector ref="fromCategorySelector" @select="onUpdateFromCategory"></category-selector>
        <category-selector ref="toCategorySelector" @select="onUpdateToCategory"></category-selector>
    </div>
</div>
</template>

<script>
import {mapState, mapGetters, mapActions, mapMutations} from 'vuex';
import CategorySelector from '@reusable/CategorySelector.vue';
import Money from '@reusable/Money.vue';

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
        onUpdateFromCategory(cat) {
            // this.category = cat;
        },
        onUpdateToCategory(cat) {
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
        grid-template-columns: 1fr 1fr;
        grid-gap: .5rem;
    }
</style>
