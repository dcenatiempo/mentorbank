<template>
<div>
    <h1>{{bank.name}}</h1>
    <h2>You don't have any accounts, lets set one up!</h2>
    <form v-on:submit.prevent>
        <label for="name">Name:</label>
        <input id="name" type="text" v-model="name"/>
        <label for="year">Birth Year:</label>
        <select v-model="year" id="year">
            <template v-for="y in years">
                <option :value="y" :key="y">{{y}}</option>
            </template>
        </select>
        <label for="month">Birth Month:</label>
        <select v-model="month" id="month">
            <template v-for="(m, index) in months">
                <option :value="index + 1" :key="m">{{m}}</option>
            </template>
        </select>
        <fieldset>
            <legend>Sex</legend>
            <input type="radio" id="m" value="m" v-model="sex">
            <label for="m">Male</label>
            <input type="radio" id="f" value="f" v-model="sex">
            <label for="f">Female</label>
        </fieldset>
        <button v-on:click="createNewAccount()">Submit</button>
    </form>
</div>
</template>

<script>
import {mapState, mapGetters, mapActions, mapMutations} from 'vuex';

export default {
    components: {},
    props: {},
    data() {
        return {
            name: '',
            year: null,
            month: null,
            sex: '',
            months: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
        };
    },
    computed: {
        ...mapState(['user', 'bank']),
        // ...mapGetters()
        years() {
            let years = [];
            let thisYear = new Date(Date.now()).getFullYear();
            for (let i = 0; i<18; i++ ) {
                years.push(thisYear--);
            }
            return years;
        }
    },
    methods: {
        // ...mapMutations(),
        ...mapActions('accounts', ['createAccount']),
        createNewAccount() {
            let account = {
                name: this.name,
                year: this.year,
                month: this.month,
                sex: this.sex
            }
            console.dir(account)
            this.createAccount(account);
        },
        
    },
    created() {
    },
    mounted() {
        console.log('NewBanker.vue mounted.')
    },
    watch: {}
}
</script>

<style>

</style>