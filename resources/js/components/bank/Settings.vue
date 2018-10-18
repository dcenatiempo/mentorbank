<template>
    <div class="container">
        <button v-on:click="$router.go(-1)">&lt;</button>
        <h2>Bank Settings</h2>
        <ul>
            <li>
                Name: {{name}}
            </li>
            <!-- <li>
                Member Since: {{memberSince}}
            </li> -->
        </ul>
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
        ...mapState('bank', ['name']),
        ...mapGetters('user', ['memberSince'])
    },
    methods: {
        // ...mapMutations(),
        // ...mapActions(),
        
    },
    created() {},
    mounted() {
        console.log('Profile.vue mounted.')
    },
    watch: {}
}
</script>

<style>

</style>
