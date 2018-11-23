<template>
    <button v-if="compact" :class="{expanded}" class="hamburger" v-on:click="toggle(!expanded)">
        <div class="bar1"></div>
        <div class="bar2"></div>
        <div class="bar3"></div>
    </button>
</template>

<script>
import {mapState, mapGetters, mapActions, mapMutations} from 'vuex';


export default {
    components: {
        
    },
    props: {
        compact: {
            type: Boolean,
            default: false
        },
        expandedProp: {
            type: Boolean,
            default: false
        },
    },
    data() {
        return {
            expanded: false
        };
    },
    computed: {
        // ...mapState(),
    },
    methods: {
        toggle(val) {
            if (val == this.expanded) return;
            this.expanded = val;
            this.$emit('toggle', this.expanded)
        }
    },
    created() {},
    mounted() {
    },
    watch: {
        compact(compact) {
            if (!compact & this.expanded) {
                this.toggle(false);
            }
        },
        expandedProp(val) {
            this.toggle(val);
        }
    }
}
</script>

<style lang="scss" scoped>
@import 'resources/sass/variables';

.hamburger {
    display: inline-block;
    cursor: pointer;
    background: transparent;
    border: none;
}

.bar1, .bar2, .bar3 {
    width: 35px;
    height: 5px;
    background-color: $black;
    margin: 6px 0;
    transition: 0.4s;
    border-radius: 2px;
}

/* Rotate first bar */
.expanded .bar1 {
    transform: rotate(-45deg) translate(-8.5px, 6px) ;
}

/* Fade out the second bar */
.expanded .bar2 {
  opacity: 0;
}

/* Rotate last bar */
.expanded .bar3 {
  transform: rotate(45deg) translate(-8px, -8px) ;
}
</style>
