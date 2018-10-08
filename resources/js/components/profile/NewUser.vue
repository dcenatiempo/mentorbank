<template>
<div>
    <h1>Welcome {{firstName}}!</h1>
    <p>You have not yet set up your account.</p>
    <p>Lets do that now.</p>
    <p>What is your bank name?</p>
    <form v-on:submit.prevent>
        <input type="radio" id="one" value="Bank of Dad" checked v-model="bankName">
        <label for="one">Bank of Dad</label>
        <br>
        <input type="radio" id="two" value="Bank of Mom" v-model="bankName">
        <label for="two">Bank of Mom</label>
        <br>
        <template v-if="lastName.length > 0">
            <input type="radio" id="three" v-bind:value="lastName + ' Family Bank'" v-model="bankName">
            <label for="three">{{lastName}} Family Bank</label>
            <br>
        </template>
        <input type="radio" id="four" v-bind:value="customBankName" v-model="bankName">
        <label for="four">Custom Name:</label>
        <input type='text' placeholder='Enter Bank Name'
            v-model.trim="customBankName">
        <button v-on:click="createBank(bankName)">Submit</button>
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
            bankName: '',
            customBankName: ''
        };
    },
    computed: {
        // ...mapState(),
        ...mapGetters('user', ['firstName', 'lastName'])
    },
    methods: {
        // ...mapMutations(),
        ...mapActions('bank', ['createBank']),
        
    },
    created() {},
    mounted() {
        console.log('NewUser.vue mounted.')
    },
    watch: {}
}
</script>

<style>

</style>