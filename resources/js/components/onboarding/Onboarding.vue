<template>
    <div class="container card">
        <h1 v-if="loading">Loading User...</h1>
        <new-user v-if="type == 'none'"></new-user>
        <new-bank v-else-if="type == 'banker'"></new-bank>
        <account-holder-profile v-else-if="type == 'account_holder'"></account-holder-profile>
    </div>
</template>

<script>
import {mapState, mapGetters, mapActions, mapMutations} from 'vuex';
import NewUser from './NewUser.vue';
import BankerProfile from './BankerProfile.vue';
import AccountHolderProfile from './AccountHolderProfile.vue';
import NewBank from './NewBank.vue';

export default {
    components: {
        'new-user': NewUser,
        'new-bank': NewBank,
        'banker-profile': BankerProfile,
        'account-holder-profile': AccountHolderProfile
    },
    props: {},
    data() {
        return {

        };
    },
    computed: {
        ...mapState('user',['type', 'loading']),
        ...mapState(['bank']),
        ...mapState('accounts', ['accountList'])
    },
    methods: {
        // ...mapMutations(),
        // ...mapActions(),
        
    },
    created() {},
    mounted() {},
    watch: {
        accountList(array) {
            if (array.length > 0) {
                window.location.replace('/home');
            }
        }
    }
}
</script>

<style>
</style>
