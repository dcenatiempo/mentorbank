<template>
<div>
    <h1>{{bank.name}}</h1>
    <h2>You don't have any accounts, lets set one up!</h2>
    <form v-on:submit.prevent>
        <label for="name">Name:</label>
        <input id="name" type="text" placeholder="Enter account holder's name" v-model="name"/>
        <label for="year">Birth Month:</label>
        <datepicker :format="'MMM yyyy'" :minimumView="'month'" :maximumView="'month'" v-model="birthDate"></datepicker>
        <label for="sex">Sex:</label>
        <div class="fieldset">
            <input type="radio" id="m" value="m" name="sex" v-model="sex">
            <label for="m">Male</label>
            <input type="radio" id="f" value="f" name="sex" v-model="sex">
            <label for="f">Female</label>
        </div>
        <button v-on:click="createNewAccount()">Submit</button>
    </form>
</div>
</template>

<script>
import {mapState, mapGetters, mapActions, mapMutations} from 'vuex';
import Datepicker from 'vuejs-datepicker';

export default {
    components: { Datepicker },
    props: {},
    data() {
        return {
            name: '',
            birthDate: moment().subtract(5, 'year').format(),
            sex: 'male',
        };
    },
    computed: {
        ...mapState(['user', 'bank']),
        // ...mapGetters()
    },
    methods: {
        // ...mapMutations(),
        ...mapActions('accounts', ['createAccount']),
        createNewAccount() {
            let account = {
                name: this.name,
                birthDate: this.birthDate,
                sex: this.sex
            }
            console.dir(account)
            this.createAccount(account);
        },
        
    },
    created() {
    },
    mounted() {},
    watch: {}
}
</script>

<style scoped lang="scss">
div.fieldset {
        display: grid;
        grid-template-columns: min-content 1fr;
        grid-column-gap: 16px;
        grid-row-gap: 16px;
        align-items: center;
        margin-bottom: 16px;

        label {
            padding: 0;
            margin: 0;
        }
        input[type=radio] {
            width: initial;
        }
        input[type=text] {
            padding: 0;
            border: none;
            min-height: initial;
            width: initial;
        }
    }
</style>