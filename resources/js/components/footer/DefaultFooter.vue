<template>
<footer>
    This is the footer
</footer>
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
        // ...mapState('user', ['name']),
        // ...mapGetters()
    },
    methods: {
        // ...mapMutations(),
        // ...mapActions(),
        
    },
    created() {},
    mounted() {
        console.log('Footer mounted.')
    },
    watch: {}
}
</script>

<style>

</style>
