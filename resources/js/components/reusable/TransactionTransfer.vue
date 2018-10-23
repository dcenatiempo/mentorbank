<template>
<div>
    <label>Amount</label>
    <money
        v-bind="moneyConfig"
        v-model="transferAmount"
        @input="updateSplit">
    </money>

    <div class="grid-row">
        <label>From</label><label>To</label>
        <multiselect
            v-model="split[0].category_id"
            :options="fromCategories"
            track-by="id"
            label="name"
            :custom-label="nameWithPrice"
            placeholder="select a category"
            selectLabel=""
            deselectLabel=""
            :allow-empty="false"
            @select="updateSplit">
            </multiselect>
        <multiselect
            v-model="split[1].category_id"
            :options="toCategories"
            track-by="id"
            label="name"
            :custom-label="nameWithPrice"
            placeholder="select a category"
            selectLabel=""
            deselectLabel=""
            :allow-empty="false"
            @select="updateSplit">
        </multiselect>
    </div>
</div>
</template>

<script>
import {mapState, mapGetters, mapActions, mapMutations} from 'vuex';
import Multiselect from 'vue-multiselect';
import CategorySelector from '@reusable/CategorySelector.vue';
import {Money} from 'v-money'

export default {
    components: {
        Multiselect,
        CategorySelector,
        Money
    },
    props: {
        subedCats: {
            type: Array,
            default: []
        }
    },
    data() {
        return {
            moneyConfig: {
                decimal: '.',
                thousands: ',',
                prefix: '$ ',
                suffix: '',
                precision: 2,
                masked: false
            },
            split: [{
                category_id: null,
                amount: 0
            },{
                category_id: null,
                amount: 0
            }],
            transferAmount: 0,
        };
    },
    computed: {
        ...mapState('accounts', ['currentAccount']),
        ...mapState(['categories']),
        // ...mapGetters(),
        fromCategories() {
            let fromCats = this.subedCats.map(cat => {
                let category = this.categories.categoryList.find(item => item.id == cat.category_id);
                return {
                    'name': category.name,
                    'id': category.id,
                    'balance': cat.balance
                };
            });
            return fromCats.filter(item => this.transferAmount <= item.balance && item.balance > 0 );
        },
        toCategories() {
            let toCats = this.subedCats.map(cat => {
                let category = this.categories.categoryList.find(item => item.id == cat.category_id);
                return {
                    'name': category.name,
                    'id': category.id,
                    'balance': cat.balance
                };
            });
            if (this.split[0].category_id) {
                return toCats.filter(item => item.id != this.split[0].category_id.id);
            }
            return toCats;
        }
    },
    methods: {
        // ...mapMutations(),
        // ...mapActions(),  
        updateSplit() {
            this.$emit('split-updated', this.split);
        },
        nameWithPrice({name, balance}) {
            return `${name}: $${balance}`;
        }
    },
    created() {},
    mounted() {
    },
    watch: {
        transferAmount(amount) {
            this.split[0].amount = amount;
            this.split[1].amount = amount;
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
