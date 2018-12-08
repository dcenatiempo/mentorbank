<template>
    <header>
        <back-btn :disabled="disabled"></back-btn>
        <div class="brand">
            <a :href="homeRoute">KidBank</a>
        </div>

        <header-navigation :expanded="expanded" :compact="compact" @toggle="setExpand">
            <ul v-if="!loggedIn">
                <li><a href="/login">Login</a></li>
                <li><a href="/register">Register</a></li>
            </ul>

            <ul v-else-if="!verified">
                <!-- <li><a href="/portal"><account-convert-icon v-if="compact"></account-convert-icon> Account</a></li> -->
                <li><logout :compact="compact"></logout></li>
            </ul>

            <ul v-else-if="'welcome' == pageId">
                <li><a href="/portal"><account-convert-icon v-if="compact"></account-convert-icon> Switch Account</a></li>
                <li><logout :compact="compact"></logout></li>
            </ul>

            <template v-else>
                <ul v-if="'/bank' == homeRoute">
                    <!-- <li><bell-icon></bell-icon></li> -->
                    <li><router-link to="/bank/profile"><account-icon v-if="compact"/>Profile</router-link></li>
                    <li><a href="/portal"><account-convert-icon v-if="compact"/>Switch Account</a></li>
                    <li><logout :compact="compact"/></li>
                </ul>

                <ul v-else-if="'/account' == homeRoute">
                    <!-- <li><bell-icon></bell-icon></li>
                    <li><router-link to="/bank/profile"><account-icon/></router-link></li> -->
                    <li v-if="accountId"><portal-logout :compact="compact"/></li>
                    <li v-else><logout :compact="compact"/></li>
                </ul>

                <ul v-else>
                    <li><logout :compact="compact"></logout></li>
                    <!-- <li><a href="/portal">Portal</a></li> -->
                </ul>
            </template>

        </header-navigation>

        <hamburger @toggle="setExpand" :compact="compact" :expandedProp="expanded"></hamburger>
    </header>
</template>

<script>
import {mapState, mapGetters, mapActions, mapMutations} from 'vuex';
import LoginIcon from 'icons/Login';
import AccountIcon from 'icons/Account';
import AccountConvertIcon from 'icons/AccountConvert';
import BackBtn from '@reusable/BackBtn';
import BellIcon from 'icons/Bell';
import Logout from './Logout';
import PortalLogout from './PortalLogout';
import HeaderNavigation from './HeaderNavigation';
import Hamburger from './Hamburger';

export default {
    components: {
        LoginIcon,
        AccountIcon,
        AccountConvertIcon,
        BellIcon,
        BackBtn,
        Logout,
        PortalLogout,
        HeaderNavigation,
        Hamburger
    },
    props: {
        loggedIn: {
            type: Boolean,
            default: false
        },
        verified: {
            type: Boolean,
            default: false
        },
        portal: {
            type: Boolean,
            default: false
        },
        accountId: {
            type: Number,
            default: 0
        },
        pageId: {
            type: String,
            default: ''
        }
    },
    data() {
        return {
            expanded: false,
        };
    },
    computed: {
        ...mapState('app', ['vpWidth']),
        // ...mapGetters(),
        homeRoute() {
            let route;

            if (!this.loggedIn)
                route = '/';
            else if ('email-verify' == this.pageId)
                route = '/';
            else if ('onboarding' == this.pageId)
                route = '/onboarding'
            else if (this.portal == false)
                route = '/bank';
            else if (this.accountId == 0)
                route = '/';
            else
                route = '/account';

            return route;
        },
        disabled() {
            if ('welcome' == this.pageId || 'email-verify' == this.pageId)
                return true;
            return '/bank' == this.homeRoute ? false : true;
        },
        compact() {
            return this.vpWidth < 500;
        }
    },
    methods: {
        ...mapMutations('app', ['setSize', 'setIsLoggedIn']),
        resizeFinished() {
            this.setSize({width: window.innerWidth, height: window.innerHeight});
        },
        setExpand(val) {
            this.expanded = val;
        }
        
    },
    created() {},
    mounted() {
        let vm = this;

        // this block will only run above function if window is done being resized
        var doit;
        window.onresize = function(){
            clearTimeout(doit);
        doit = setTimeout(vm.resizeFinished, 50);
        };

        this.setIsLoggedIn(this.loggedIn);
    },
    watch: {}
}
</script>

<style lang="scss">

    header {
        z-index: 1;
        display: grid;
        grid-template-columns: 30px min-content 1fr;
        grid-template-areas: "back brand nav";
        align-items: center;
        justify-items: start;
        padding: 0 1rem;
        background: white;
        box-shadow: 0 4px 9px -4px rgba(0,0,0,.2);

        .back {
            grid-area: back;
        }
        
        .brand {
            display: flex;
            justify-content: center;
            grid-area: brand;
        }
        nav {
            grid-area: nav;
            justify-self: end;
        }
        .hamburger {
            grid-area: nav;
            justify-self: end;
        }
        li a span {
            margin-right: 1rem;
        }
    }
    
</style>
