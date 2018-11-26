<template>
    <div v-if="goal > 0" class="goal-meter">
        <!-- {{balance}} is {{percent}}% of the way to {{goal}} -->
        <span class="label">{{percent}}%</span>
        <div class="left" :style="`width: ${percent}%`"></div>
        <div class="right" :style="`width: ${100 - percent}%`"></div>
    </div>
    <div v-else></div>
</template>

<script>
import {mapState, mapGetters, mapActions, mapMutations} from 'vuex';

export default {
    components: {},
    props: {
        balance: {
            type: Number,
            default: 0
        },
        goal: {
            type: Number,
            default: 0
        }
    },
    data() {
        return {

        };
    },
    computed: {
        percent() {
            return Math.round(this.balance *100 / this.goal);
        }
    },
    methods: {        
    },
    created() {},
    mounted() {},
    watch: {}
}
</script>

<style lang="scss">
@import 'resources/sass/_variables.scss';

    .goal-meter {
        position: relative;
        display: flex;
        height: 1.5rem;
        width: 100%;
        border-radius: 1rem;
        overflow: hidden;
        max-width: 100%;

        .label {
            position: absolute;
            left: 50%;
            transform: translate(-50%);
            font-size: 1rem;
        }

        .left, .right {
            height: 100%;
        }
        .left {
            background: $green;
        }
        .right {
            background: $lightgray;
        }
    }

</style>
