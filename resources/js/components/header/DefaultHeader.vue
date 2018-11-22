<template>

    <header v-if="!loggedIn">
        <div class="brand">
            <a href="/">MentorBank</a>
        </div>
        <nav>
            <ul>
                <li><a href="/login">Login</a></li>
                <li><a href="/register">Register</a></li>
            </ul>
        </nav>
    </header>

    <header v-else-if="'welcome' == pageId">
        <div class="brand">
            <a :href="homeRoute">MentorBank</a>
        </div>
        <nav>
            <ul>
                <li><logout></logout></li>
                <li><a href="/portal">Portal</a></li>
            </ul>
        </nav>
    </header>

    <header v-else>
        <back-btn :disabled="disabled"></back-btn>
        <div class="brand">
            <router-link v-if="'/bank' == homeRoute" :to="homeRoute">MentorBank</router-link>
            <a v-else :href="homeRoute">MentorBank</a>
        </div>
        <nav v-if="'/bank' == homeRoute">
            <ul>
                <!-- <li><bell-icon></bell-icon></li> -->
                <li><router-link to="/bank/profile"><account-icon/></router-link></li>
                <li><logout></logout></li>
                <li><a href="/portal">Portal</a></li>
            </ul>
        </nav>
         <nav v-else-if="'/account' == homeRoute">
            <ul>
                <!-- <li><bell-icon></bell-icon></li>
                <li><router-link to="/bank/profile"><account-icon/></router-link></li> -->
                <li v-if="accountId"><portal-logout></portal-logout></li>
                <li v-else><logout></logout></li>
            </ul>
        </nav>
        <nav v-else>
            <ul>
                <li><logout></logout></li>
                <!-- <li><a href="/portal">Portal</a></li> -->
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
        loggedIn: {
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
            // loggedOut: /         !loggedIn   
            //  portal: /portal     loggedIn    portal  accountId == 0
            //  bank: /bank         loggedIn    
            //  account: /account   loggedIn    portal  accountId > 0
        };
    },
    computed: {
        // ...mapState(),
        // ...mapGetters(),
        homeRoute() {
            let route;

            if (!this.loggedIn)
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
            if ('welcome' == this.pageId)
                return true;
            return '/bank' == this.homeRoute ? false : true;
        }
    },
    methods: {
        ...mapMutations('app', ['setSize', 'setIsLoggedIn']),
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

        this.setIsLoggedIn(this.loggedIn);
    },
    watch: {}
}
</script>

<style lang="scss">

    header {
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

            ul {
                display: flex;
                flex-flow: row nowrap;
                justify-content: flex-end;
                padding: 0;
                margin: 0;

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
    }
    
</style>
