<template>
    <multiselect
      v-model="selected"
      :options="accountList"
      track-by="accountId"
      label="accountHolderName"
      placeholder="select an account"
      :allow-empty="false"
      :hideSelected="true"
      @select="onSelect"
      :value="value">
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
            selected: null,
            value: null
        };
    },
    computed: {
        ...mapState(['accounts']),
        // ...mapGetters(),
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
        ...mapMutations('accounts', ['setCurrentById']),
        // ...mapActions(),
        onSelect(value) {
            let accountId = value ? value.accountId : null;
            this.setCurrentById(accountId);
            this.$emit('select', value);
        },
        reset() {
            let val = null;
            this.selected = val;
            this.onSelect(val);
        }
    },
    created() {},
    mounted() {},
    watch: {}
}
</script>

<style>

</style>

<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>
