<template>
    <a href="/logout" v-on:click.prevent="logout">
        <logout-icon  v-if="compact"/>
        Logout
        <form id="logout-form" action="/logout" method="POST" style="display: none;">
            <input type="hidden" name="_token" :value="csrf">
        </form>
    </a>          
</template>

<script>
import LogoutIcon from 'icons/Logout';

export default {
    components: {
        LogoutIcon
    },
    props: {
        compact: Boolean,
    },
    data() {
        return {
            csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
        }
    },
    methods: {
        logout() {
            document.getElementById('logout-form').submit();
        }
    }
}
</script>

<style>

</style>
