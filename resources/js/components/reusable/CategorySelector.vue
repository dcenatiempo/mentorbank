<template>
    <multiselect
      v-model="selected"
      :options="categories.categoryList"
      track-by="id"
      label="name"
      placeholder="select a category"
      :allow-empty="false"
      deselectLabel=""
      @select="onSelect">
    </multiselect>
</template>

<script>
import Multiselect from 'vue-multiselect';
import {mapState, mapGetters, mapActions, mapMutations} from 'vuex';

export default {
    components: {
        Multiselect
    },
    props: {},
    data() {
        return {
            selected: {id: 3, name: 'Uncategorized'},
        };
    },
    computed: {
        ...mapState(['categories']),
        // ...mapGetters()
    },
    methods: {
        // ...mapMutations(),
        // ...mapActions(),
        onSelect(value) {
            this.$emit('select', value);
        },
        reset() {
            let val = {id: 3, name: 'Uncategorized'}
            this.selected = val;
            this.onSelect(val);
        }
        
    },
    created() {},
    mounted() {
        this.onSelect(this.selected);
    },
    watch: {}
}
</script>

<style>

</style>

<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>
