<template>
    <a href="/portal/logout" v-on:click.prevent="logout">
        <account-convert-icon  v-if="compact"/>
        Switch Account
        <form id="logout-form" action="/portal/logout" method="POST" style="display: none;">
            <input type="hidden" name="_token" :value="csrf">
        </form>
    </a>          
</template>

<script>
import AccountConvertIcon from 'icons/AccountConvert';

export default {
    components: {
        AccountConvertIcon
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
