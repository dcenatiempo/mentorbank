<template>
    <nav :class="{expanded, compact}" v-on:click="collapseNav">
        <slot></slot>
    </nav>
</template>

<script>
import {mapState, mapGetters, mapActions, mapMutations} from 'vuex';


export default {
    components: {
        
    },
    props: {
        expanded: {
            type: Boolean,
            default: false
        },
        compact: {
            type: Boolean,
            default: false 
        }
    },
    data() {
        return {
        };
    },
    computed: {
        // ...mapState(),
        // ...mapGetters(),
    },
    methods: {
        collapseNav() {
            if (this.compact) {
                this.$emit('toggle', false);
            }
        }
    },
    created() {},
    mounted() {
    },
    watch: {}
}
</script>

<style lang="scss">
    nav {
        overflow-x: hidden;

        ul {
            display: flex;
            position: relative;
            flex-flow: row nowrap;
            justify-content: flex-end;
            padding: 0;
            margin: 0;
            width: 100%;

            li {
                list-style: none;

                a {
                    color: #636b6f;
                    padding: 0 1rem;
                    font-size: 12px;
                    font-weight: 600;
                    letter-spacing: .1rem;
                    text-decoration: none;
                    text-transform: uppercase;
                }
            }
        }
    }

    nav.compact {
        position: absolute;
        top: 3rem;
        right: -1rem;
        background: transparent;
        width: 0;
        height: calc(100vh - 3rem);
        transition: width ease 300ms;
        
        ul {
            position: absolute;
            right: 0;
            width: 0;
            transition: width ease 300ms;
            height: 100%;
            background: white;
            box-shadow: -4px 4px 9px -4px rgba(0, 0, 0, 0.2);
            flex-flow: column nowrap;
            justify-content: flex-start;
            white-space: nowrap;
            padding-top: 1rem;

            li {
                margin-bottom: 1.5rem;
            }
        }

        &.expanded {
            width: 100vw;
            ul {
                width: 220px;
            }
        }
    }
</style>
