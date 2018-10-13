<template>
    <multiselect
      v-model="selected"
      :options="transactionTypeList"
      placeholder="select a type"
      :allow-empty="false"
      deselectLabel=""
      @select="onSelect">
    </multiselect>
</template>

<script>
import Multiselect from 'vue-multiselect';
import {mapState, mapGetters, mapActions, mapMutations} from 'vuex';

export default {
    components: {
        Multiselect,
    },
    props: {},
    data() {
        return {
            selected: 'deposit',
            transactionTypeList: ['deposit', 'withdrawal', 'transfer']
        };
    },
    computed: {
        ...mapState(['accounts']),
        // ...mapGetters()
        accountList() {
            return this.accounts.accountList.map(item => (
                {
                    accountHolderName: item.accountHolder.name,
                    accountId: item.id
                }
            ));
        },

    },
    methods: {
        // ...mapMutations(),
        // ...mapActions(),
        onSelect(value) {
            this.$emit('select', value);
        },
        reset() {
            let val = 'deposit';
            this.selected = val;
            this.onSelect(val)
        }
        
    },
    created() {},
    mounted() {
        this.onSelect(this.selected);
    },
    watch: {}
}
</script>

<style>

</style>

<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>
