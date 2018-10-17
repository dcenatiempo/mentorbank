<template>
<div>
    <h1>Welcome {{firstName}}!</h1>
    <p>You have not yet set up your account.</p>
    <p>Lets do that now.</p>
    <p>What is your bank name?</p>
    <form v-on:submit.prevent>
        <div class="fieldset">
            <input type="radio" name="bank-name" id="dad" value="Bank of Dad" v-model="bankName">
            <label for="dad">Bank of Dad</label>
            <input type="radio" name="bank-name" id="mom" value="Bank of Mom" v-model="bankName">
            <label for="mom">Bank of Mom</label>
            <template v-if="lastName.length > 0">
                <input type="radio" name="bank-name" id="family" v-bind:value="lastName + ' Family Bank'" v-model="bankName">
                <label for="family">{{lastName}} Family Bank</label>
            </template>
            <input type="radio" name="bank-name" id="custom" v-bind:value="customBankName" v-model="bankName">
            <input type='text' placeholder='Enter Custom Bank Name'
                v-model.trim="customBankName"
                v-on:input="focusCustomRadio">
        </div>
        <button v-on:click="handleClick">Submit</button>
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
            bankName: 'Bank of Dad',
            customBankName: ''
        };
    },
    computed: {
        // ...mapState(),
        ...mapGetters('user', ['firstName', 'lastName'])
    },
    methods: {
        ...mapMutations('user', ['setType']),
        ...mapActions('bank', ['createBank']),
        focusCustomRadio() {
            this.bankName = this.customBankName;
        },
        handleClick () {
            let vm = this;
            this.createBank(this.bankName)
            .then( () => {
                vm.setType('banker');
            }).catch( err => {
                console.error(err);
            })
        }
    },
    created() {},
    mounted() {
        console.log('NewUser.vue mounted.')
    },
    watch: {}
}
</script>

<style lang="scss" scoped>
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