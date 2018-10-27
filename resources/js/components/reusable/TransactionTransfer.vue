<template>
<div>
    <label>Amount</label>
    <!-- <money
        v-bind="moneyConfig"
        v-model="transferAmount"
        @input="updateSplit">
    </money> -->

    <div class="grid-row">
        <label>From</label><label>To</label>
        <multiselect
            v-model="split[0].category"
            :options="fromCategories"
            track-by="id"
            label="name"
            :custom-label="nameWithPrice"
            placeholder="select a category"
            selectLabel=""
            deselectLabel=""
            :allow-empty="false"
            :disabled="fromCategories.length == 0"
            @select="updateSplit">
            </multiselect>
        <multiselect
            v-model="split[1].category"
            :options="toCategories"
            track-by="id"
            label="name"
            :custom-label="nameWithPrice"
            placeholder="select a category"
            selectLabel=""
            deselectLabel=""
            :allow-empty="false"
            :disabled="fromCategories.length == 0"
            @select="updateSplit">
        </multiselect>
    </div>
</div>
</template>

<script>
import {mapState, mapGetters, mapActions, mapMutations} from 'vuex';
import Multiselect from 'vue-multiselect';
import CategorySelector from '@reusable/CategorySelector.vue';

export default {
    components: {
        Multiselect,
        CategorySelector,
    },
    props: {
        subedCats: {
            type: Array,
            default: []
        },
        amount: {
            type: Number,
            default: 0
        }
    },
    data() {
        return {
            split: [{
                category: null,
                amount: 0
            },{
                category: null,
                amount: 0
            }]
        };
    },
    computed: {
        ...mapState('accounts', ['currentAccount']),
        ...mapState(['categories']),
        // ...mapGetters(),
        fromCategories() {
            let categoryList = this.categories.categoryList;
            let split = this.split;
            let amount = this.amount;
            let fromCats = this.subedCats.map(cat => {
                let category = categoryList.find(item => item.id == cat.categoryId);
                return {
                    'name': category.name,
                    'id': category.id,
                    'balance': cat.balance
                };
            });
            if (this.split[1].category) {
                fromCats = fromCats.filter(item => item.id != split[1].category.id);
            }
            return fromCats.filter(item => amount <= item.balance && item.balance > 0 );
        },
        toCategories() {
            let toCats = this.subedCats.map(cat => {
                let category = this.categories.categoryList.find(item => item.id == cat.categoryId);
                return {
                    'name': category.name,
                    'id': category.id,
                    'balance': cat.balance
                };
            });
            if (this.split[0].category) {
                return toCats.filter(item => item.id != this.split[0].category.id);
            }
            return toCats;
        }
    },
    methods: {
        // ...mapMutations(),
        // ...mapActions(),  
        updateSplit() {
            let vm = this;
            setTimeout( () => {
                vm.$emit('split-updated', vm.split);
            },0)
            
        },
        nameWithPrice({name, balance}) {
            return `${name}: $${balance}`;
        }
    },
    created() {},
    mounted() {
    },
    watch: {
        amount (amount) {
            let max = this.split[0].category ? this.split[0].category.balance : amount;
            amount = amount > max ? max : amount;
            this.split[0].amount = amount;
            this.split[1].amount = amount;
            this.updateSplit();
        }
    }
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
<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>
