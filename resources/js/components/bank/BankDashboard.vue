<template>
<div>
    <h1>{{bank.name}} Dashboard</h1>
    <hr>
    <h2>Accounts</h2>
    <template v-for="account in accounts.accountList">
        <div :key="account.id">
            <h3>{{account.accountHolder.name}}</h3>
        </div>
    </template>
    <hr>
    <h2>Categories</h2>
    <template v-for="category in categories.categoryList">
        <div :key="category.id">
            <h3>{{category.name}}</h3>
        </div>
    </template>
    <hr>
    <h2>Transactions</h2>
    <hr>
    <h2>Recurring Transactions</h2>
</div>
</template>

<script>
import {mapState, mapGetters, mapActions, mapMutations} from 'vuex';

export default {
    components: {},
    props: {},
    data() {
        return {

        };
    },
    computed: {
        ...mapState('user', ['name']),
        ...mapState(['bank', 'accounts', 'categories'])
        // ...mapGetters()
    },
    methods: {
        ...mapActions('categories', ['getAllCategories']),
    },
    created() {
        this.getAllCategories();
    },
    mounted() {
        console.log('BankDashboard.vue mounted.')
    },
    watch: {}
}
</script>

<style>

</style>
