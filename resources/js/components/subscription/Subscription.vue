<template>
    <div class="container">
        <div v-if="downgrade">
            Your subscription is expired. your bank needs to be downgraded
        </div>
        <div v-else-if="'free' == planType">
            Would you like a subscription?
        </div>
        <div v-else-if="isInGracePeriod">
            Your subscription has expired, please renew!
            <span v-if="exceedLimits">
                if you don't renew you will have to delete some accounts and/or categories
            </span>
        </div>
        <div v-else>
            You have a subscription!
        </div>

    </div>
</template>

<script>
import {mapState, mapGetters, mapActions, mapMutations} from 'vuex';

export default {
    components: {},
    props: {
        downgrade: {
            type: Boolean,
        }
    },
    data() {
        return {

        };
    },
    computed: {
        ...mapState('user', ['name']),
        ...mapState('bank', ['planType', 'downgradeBank']),
        ...mapState('accounts', ['accountList']),
        ...mapState('categories', ['categoryList']),
        ...mapGetters('bank', ['isExpired', 'isInGracePeriod']),
        exceedLimits() {
            return (this.accountList.length > 1 || this.categoryList.length > 5);
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
