<template>
    <div class="container">
        <h2>Bank Settings</h2>
        <ul>
            <li>
                Name: {{name}}
            </li>
            <li>
                Open Since: {{openSince}}
            </li>
            <li>
                Plan Type: {{planType}}
            </li>
            <li>
                Expires: {{expires}}
            </li>
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
        ...mapState('bank', ['name', 'planType', 'expires']),
        ...mapGetters('bank', ['openSince'],)
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
