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
            placeholder="select a category"
            :allow-empty="false"
            deselectLabel=""
            @select="updateSplit">
            </multiselect>
        <multiselect
            v-model="split[1].category_id"
            :options="toCategories"
            track-by="id"
            label="name"
            placeholder="select a category"
            :allow-empty="false"
            deselectLabel=""
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
    props: {},
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
            return this.categories.categoryList;
        },
        toCategories() {
            return this.categories.categoryList;
        }
    },
    methods: {
        // ...mapMutations(),
        // ...mapActions(),  
        updateSplit() {
            this.$emit('split-updated', this.split);
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
