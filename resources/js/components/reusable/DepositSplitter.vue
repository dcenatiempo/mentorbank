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
            v-model="split[index].category"
            :options="depositCats[index]"
            track-by="id"
            label="name"
            :custom-label="nameWithPrice"
            placeholder="select a category"
            selectLabel=""
            deselectLabel=""
            :disabled="isEmpty(depositCats[0][0])"
            :preselect-first="depositCats[index].length == 1
                && !depositCats[index][index]"
            @select="handleCatChange">
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
                category: null,
                amount: 0
            }],
            blank: {
                category: null,
                amount: 0
            }
        };
    },
    computed: {
        ...mapState(['categories']),
        // ...mapGetters()
        shouldShowAdd() {
            return this.formattedCats.length > this.split.length;
        },
        shouldShowRemove() {
            return this.split.length > 1;
        },
        formattedCats() {
            if (!this.subedCats || this.subedCats.length == 0) return [];
            return this.subedCats.map(cat => {
                let category = this.categories.categoryList.find(item => item.id == cat.category_id);
                return {
                    'name': category.name,
                    'id': category.id,
                    'balance': cat.balance
                };
            });
        },
        depositCats() {
            let vm = this;
            if (this.formattedCats.length == 0) {
                return [[{}]];
            } else {
                return this.split.map((item, i) => {
                    let takenIds = [...vm.selectedCats];
                    takenIds.splice(i, 1);
                    return vm.formattedCats.filter((item) => !takenIds.includes(item.id));
                });
            }
        },
        selectedCats() {
            return this.split.reduce((array, split) => {
                let catId = split.category ? split.category.id : null
                return array.concat(catId);
            }, [])
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
        },
        handleCatChange(val) {
            console.log(val);
            this.updateSplit();
        },
        nameWithPrice({name, balance}) {
            return `${name}: $${balance}`;
        },
        isEmpty(obj) {
            for(var prop in obj) {
                if(obj.hasOwnProperty(prop))
                    return false;
            }
            return JSON.stringify(obj) === JSON.stringify({});
        }
    },
    created() {},
    mounted() {
        this.handleCatChange();
    },
    watch: {

    }
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