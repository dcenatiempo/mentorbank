<template>
    <div class="container">
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
    mounted() {},
    watch: {}
}
</script>

<style>

</style>
