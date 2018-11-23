<template>
<div>

    <h1 class="top-section">{{bank.name}} Portal</h1>

    <section class="card-container">
        <div class="card">
            <h2 class="card-header">
                Choose Account
            </h2>
            <!-- <template v-if="accounts.loading">
                <div class="loader"></div>
            </template> -->
            <form>
                <multiselect
                    v-model="selectedAccount"
                    :options="accountList"
                    track-by="accountId"
                    label="accountHolderName"
                    placeholder="select account"
                    :preselect-first="false"
                    :multiple="false"
                    :allow-empty="false"
                    :hideSelected="false"
                    @select="onSelectAccount">
                </multiselect>
                <input type="text" placeholder="enter pin" v-model="pin">
                <div class="row">
                    <span v-if="error" class="invalid-feedback">{{error}}</span>
                    <button class="btn-confirm" v-on:click.prevent="checkPin">Login</button>
                </div>
            </form>
        </div>

    </section>

</div>
</template>

<script>
import {mapState, mapGetters, mapActions, mapMutations} from 'vuex';
import Multiselect from 'vue-multiselect';

export default {
    components: {
        Multiselect,
    },
    props: {},
    data() {
        return {
            selectedAccount: null,
            pin: '',
            error: ''
        };
    },
    computed: {
        ...mapState(['user', 'bank', 'accounts']),
        ...mapGetters('user', ['firstName']),
        accountList() {
            let accounts = this.accounts.accountList.map(item => (
                {
                    accountHolderName: item.accountHolder.name,
                    accountId: item.id
                }
            ));
            accounts.push({
                accountHolderName: `Bank President: ${this.firstName}`,
                accountId: 0
            });

            return accounts;
        },
        isSingleAccount() {
            return this.accountList.length === 1;
        },

    },
    methods: {
        // ...mapMutations('app', ['showModal', 'hideModal']),
        moment(d) {
            return moment(d);
        },
        onSelectAccount(value) {
            // let accountId = value ? value.accountId : null;
            // this.setCurrentById(accountId);
        },
        checkPin() {
            let id = this.selectedAccount.accountId;
            let pin = this.pin;
            let route = 0 == id ? 'bank' : 'account';
            axios.post(`/api/portal/${route}`, {id, pin})
            .then( response => {
                window.location.replace('/home')
            })
            .catch(err => {
                this.error = err.response.data.error;
            });
        }
    },
    created() {
    },
    mounted() {
        // this.unSetCurrent();
    },
    watch: {}
}
</script>

<style lang="scss">
@import 'resources/sass/variables';

#portal {
    // display: grid;
    // grid-gap: 1rem;
    
    .top-section {
        background: white;
        grid-column: 1 / end;
        padding: 1rem;
    }

    .card-container {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
        grid-gap: 1rem;

        .card {
            padding: 1rem;
            background: white;

            .card-header {
                display: flex;
                justify-content: space-between;
            }
        }
    }

    table {
        width: 100%;

        tr:nth-child(even) {
            background-color: $lightgray;
        }

        td {
            &.align-right {
                text-align: right;
            }
        }

    }

    form {
        .row {
            display: flex;
        }
        button {
            align-self: flex-end;
            margin-top: 1rem;
            margin-left: auto;
        }
    }
    
}

</style>
<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>
