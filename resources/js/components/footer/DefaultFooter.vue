<template>
    <footer>
        &#169; {{date}} Devin Cenatiempo
    </footer>
</template>

<script>
import {mapState, mapGetters, mapActions, mapMutations} from 'vuex';

export default {
    components: {},
    props: {},
    data() {
        return {
            date: moment().format('MMM YYYY')
        };
    },
    computed: {
        // ...mapState('user', ['name']),
        // ...mapGetters()
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
    footer {
        display: flex;
        justify-content: center;
        padding: 1rem;
    }
</style>
