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
            <template v-if="planType != 'free'">
                <li>
                    Expires: {{planExpires ? planExpires.date : 'Never'}}
                </li>
                <li v-if="planExpires">
                    Auto-renew: {{autoRenew ? 'Yes' : 'No'}}
                </li>
                <li v-if="inGracePeriod">
                    {{30 - inGracePeriod}} days left in grace period!
                </li>
            </template>
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
        ...mapState('bank', ['name', 'planType', 'planExpires', 'autoRenew']),
        ...mapGetters('bank', ['openSince']),
        inGracePeriod() {
            let expires = moment.utc(this.planExpires);
            let now = moment.utc();
            if (expires > now) return false;
            let dif = now.diff(expires, 'days');
            if (dif > 30) return false;
            return dif;
        }
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
