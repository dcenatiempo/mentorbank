<template>
    <header>
        <!-- <back-btn></back-btn> -->
        <div class="brand">
            <a href="/home">KidBank</a>
        </div>
        <nav>
            <ul>
                <!-- <li><bell-icon></bell-icon></li>
                <li><router-link to="/bank/profile"><account-icon/></router-link></li> -->
                <li v-if="accountId"><portal-logout></portal-logout></li>
                <li v-else><logout></logout></li>
            </ul>
        </nav>
    </header>
</template>

<script>
import {mapState, mapGetters, mapActions, mapMutations} from 'vuex';
import AccountIcon from 'icons/Account';
import BackBtn from '@reusable/BackBtn';
import BellIcon from 'icons/Bell';
import Logout from './Logout';
import PortalLogout from './PortalLogout';

export default {
    components: {
        AccountIcon,
        BellIcon,
        BackBtn,
        Logout,
        PortalLogout
    },
    props: {
        accountId: Number
    },
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
        display: grid;
        grid-template-columns: 2rem auto auto;
        align-items: center;
        padding: 0 1rem;
        background: white;
        box-shadow: 0 4px 9px -4px rgba(0,0,0,.2);

        .brand {
            display: flex;
            justify-content: center;
        }

        nav {
            ul {
                display: flex;
                flex-flow: row nowrap;
                justify-content: flex-end;
                padding: 0;
                margin: 0;

                li {
                    list-style: none;
                }
            }
        }
    }
    
</style>
