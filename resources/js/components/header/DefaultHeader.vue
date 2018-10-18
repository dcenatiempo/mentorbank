<template>
    <header>
        <div class="brand">
            <a href="/home">MentorBank</a>
        </div>
        <div class="widgets">
            <button>Notifications</button>
        </div>
        <nav>
            <ul>
                <li><a href="/profile">profile</a></li>
                <li><a href="/bank">bank</a></li>
                <li><router-link to="/bank/profile"><account-icon/></router-link></li>
                <li><logout></logout></li>
            </ul>
        </nav>
    </header>
</template>

<script>
import {mapState, mapGetters, mapActions, mapMutations} from 'vuex';
import AccountIcon from 'icons/Account';
import Logout from './Logout';

export default {
    components: {
        AccountIcon,
        Logout
    },
    props: {},
    data() {
        return {

        };
    },
    computed: {
        // ...mapState(),
        // ...mapGetters()
    },
    methods: {
        ...mapMutations('app', ['setSize']),
        // ...mapActions(),
        resizeFinished() {
            this.setSize({width: window.innerWidth, height: window.innerHeight});
        }
        
    },
    created() {},
    mounted() {
        let vm = this;
        // this block will only run above functioin if window is done being resized
        var doit;
        window.onresize = function(){
            clearTimeout(doit);
        doit = setTimeout(vm.resizeFinished, 50);
        };
    },
    watch: {}
}
</script>

<style lang="scss" scoped>
    header {
        display: flex;
        flex-flow: row nowrap;
    }
    nav {
        ul {
            display: flex;
            flex-flow: row nowrap;
            padding: 0;
            margin: 0;

            li {
                display: flex;
                flex-flow: row nowrap;
                list-style: none;
            }
        }
    }
</style>
