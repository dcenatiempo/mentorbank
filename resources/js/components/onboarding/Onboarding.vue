<template>
    <section class="card-container single">
        <h1 v-if="loading">Loading User...</h1>
        <new-user v-if="type == 'none'" class="card"></new-user>
        <new-bank v-else-if="type == 'banker'" class="card"></new-bank>
    </section>
</template>

<script>
import {mapState, mapGetters, mapActions, mapMutations} from 'vuex';
import NewUser from './NewUser.vue';
import NewBank from './NewBank.vue';

export default {
    components: {
        'new-user': NewUser,
        'new-bank': NewBank,
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
