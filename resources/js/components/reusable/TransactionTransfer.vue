<template>
<div>
    <label>Amount</label>
    <money ref="money" @change="onUpdateMoney"></money>

    <div class="grid-row">
        <label>From</label><label>To</label>
        <multiselect
            v-model="fromSelected"
            :options="fromCategories"
            track-by="id"
            label="name"
            placeholder="select a category"
            :allow-empty="false"
            deselectLabel=""
            @select="onFromSelect">
            </multiselect>
        <multiselect
            v-model="toSelected"
            :options="toCategories"
            track-by="id"
            label="name"
            placeholder="select a category"
            :allow-empty="false"
            deselectLabel=""
            @select="onToSelect">
        </multiselect>
    </div>
</div>
</template>

<script>
import {mapState, mapGetters, mapActions, mapMutations} from 'vuex';
import Multiselect from 'vue-multiselect';
import CategorySelector from '@reusable/CategorySelector.vue';
import Money from '@reusable/Money.vue';

export default {
    components: {
        Multiselect,
        CategorySelector,
        Money
    },
    props: {},
    data() {
        return {
            fromSelected: '',
            toSelected: ''
        };
    },
    computed: {
        ...mapState('accounts', ['currentAccount']),
        // ...mapGetters(),
        fromCategories() {
            return [];
        },
        toCategories() {
            return [];
        }
    },
    methods: {
        // ...mapMutations(),
        // ...mapActions(),  
        onUpdateMoney(money) {
            // this.amount = money;
        },
        onToSelect(cat) {
            // this.category = cat;
        },
        onFromSelect(cat) {
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
<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>
