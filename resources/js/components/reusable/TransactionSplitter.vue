<template>
<div class="flex-col">
    <div class="grid-row">
        <label>Amount</label>
        <label>Category</label>
    </div>
    <div class="grid-row"
        v-for="(row, index) in split"
        :key="`split-${index}`">
        <money
            v-bind="moneyConfig"
            v-model="split[index].amount"
            @input="updateSplit">
        </money>
        <multiselect
            v-model="split[index].category_id"
            :options="categories.categoryList"
            track-by="id"
            label="name"
            placeholder="select a category"
            :allow-empty="false"
            deselectLabel=""
            @select="updateSplit">
        </multiselect>
        <button class="remove-btn"
            v-if="shouldShowRemove"
            v-on:click="removeCategory(index)">
            <remove></remove>
        </button>
    </div>
    <button class="add-btn"
        v-if="shouldShowAdd"
        v-on:click="addCategory">
        + Add Category
    </button>
</div>
</template>

<script>
import {mapState, mapGetters, mapActions, mapMutations} from 'vuex';

import Multiselect from 'vue-multiselect';
import {Money} from 'v-money'
import MinusCircle from 'icons/MinusCircle';

export default {
    components: {
        Multiselect,
        Money,
        'remove': MinusCircle
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
                category_id: { id: 2, name: "Uncategorized" },
                amount: 0
            }],
            blank: {
                category_id: { id: 2, name: "Uncategorized" },
                amount: 0
            },
        };
    },
    computed: {
        ...mapState(['categories']),
        // ...mapGetters()
        shouldShowAdd() {
            return this.categories.categoryList.length > this.split.length;
        },
        shouldShowRemove() {
            return this.split.length > 1;
        }
    },
    methods: {
        // ...mapMutations(),
        // ...mapActions(),
        addCategory() {
            if (this.shouldShowAdd) {
                this.split = [...this.split].concat(Object.assign({}, this.blank));
                this.updateSplit();
            }
        },
        removeCategory(index) {
            if (this.shouldShowRemove) {
                this.split.splice(index, 1);
                this.updateSplit();
            }
        },
        updateSplit() {
            this.$emit('split-updated', this.split);
        }
    },
    created() {},
    mounted() {
    },
    watch: {}
}
</script>

<style lang="scss" scoped>
@import 'resources/sass/_variables.scss';

    .row {
        display: flex;
    }
    .grid-row {
        display: grid;
        grid-template-columns: 1fr 2fr min-content;
        grid-gap: .5rem;
        align-items: flex-start;
    }
    .flex-col {
        display: flex;
        flex-flow: column nowrap;
    }
    .remove-btn {
        background: transparent;
        border: none;
        padding: 0;
    }
    .add-btn {
        background: transparent;
        border: none;
        margin-left: auto;
        color: $blue;
    }
</style>
