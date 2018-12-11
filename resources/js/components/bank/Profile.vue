<template>
    <div class="container">
        <h2>Profile Page<button v-on:click="showProfileModal" class="btn-icon"><edit></edit></button></h2>
        <ul>
            <li>
                Name: {{user.name}}
            </li>
            <li>
                Email: {{user.email}}
            </li>
            <li>
                Portal Pin: {{user.pin}}
            </li>
            <li>
                Member Since: {{memberSince}}
            </li>
        </ul>
    </div>
</template>

<script>
import {mapState, mapGetters, mapActions, mapMutations} from 'vuex';
import Pencil from 'icons/pencil';

export default {
    components: {
        'edit': Pencil
    },
    props: {},
    data() {
        return {

        };
    },
    computed: {
        ...mapState(['user']),
        ...mapGetters('user', ['memberSince'])
    },
    methods: {
        ...mapMutations('app', ['showModal', 'hideModal']),
        // ...mapActions(),
        showProfileModal() {
            this.showModal({
                modalId: 'profile-modal',
                payload: {
                    user: this.user
                }
            });
        }
    },
    created() {},
    mounted() {},
    watch: {}
}
</script>

<style>

</style>
