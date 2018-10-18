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
                <li><account-icon/></li>
                <li>{{vpWidth}}</li>
            </ul>
        </nav>
        <!-- <nav class="navbar navbar-expand-md navbar-light navbar-laravel">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">

                    <ul class="navbar-nav mr-auto">

                    </ul>


                    <ul class="navbar-nav ml-auto">

                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            <li class="nav-item">
                                @if (Route::has('register'))
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                @endif
                            </li>
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav> -->
        
    </header>
</template>

<script>
import {mapState, mapGetters, mapActions, mapMutations} from 'vuex';
import AccountIcon from 'icons/Account';

export default {
    components: {
        'account-icon': AccountIcon
    },
    props: {},
    data() {
        return {

        };
    },
    computed: {
        ...mapState('app', ['vpWidth']),
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
