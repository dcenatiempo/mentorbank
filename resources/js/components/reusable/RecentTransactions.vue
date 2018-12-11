<template>
    <div class="card" id="recent-transactions">

        <h2 class="card-header">Recent Transactions</h2> 

        <template v-if="accounts.loading">
            <div class="loader"></div>
        </template>

        <table v-else>
            <template class="transaction-grid"  v-for="transaction in transactionList.slice(0, 10)">
                <tr :key="'t-'+transaction.id">
                    <td class="date">
                        {{moment(transaction.createdAt.date)}}
                    </td>
                    <td class="details">
                        <span v-if="'bank' == context" class="name">
                            {{accounts.accountList.find( item => item.id == transaction.accountId).accountHolder.name}}
                        </span>
                        <span v-else-if="'account' == context" class="categories">{{getCategories(transaction)}}</span>
                        <span class="memo" v-if="transaction.memo"><br>{{transaction.memo}}</span>
                    </td>
                    <td class="type">
                        <transfer v-if="transaction.type == 'transfer'" class="transfer"></transfer>
                        <deposit v-else-if="transaction.type == 'deposit'" class="deposit"></deposit>
                        <withdrawal v-else-if="transaction.type == 'withdrawal'" class="withdrawal"></withdrawal>
                    </td>
                    <td class="amount">
                        <currency :amount="transaction.netAmount"></currency>
                    </td>
                    <!-- <td>
                        <button v-on:click="editTransaction" class="btn-icon"><edit></edit></button>
                    </td> -->
                </tr>
            </template>
        </table>

    </div>
</template>

<script>
import {mapState, mapGetters, mapActions, mapMutations} from 'vuex';
import Currency from '@reusable/Currency';
import BankTransfer from 'icons/BankTransfer';
import BankTransferIn from 'icons/BankTransferIn';
import BankTransferOut from 'icons/BankTransferOut';
import Pencil from 'icons/pencil';

export default {
    components: {
        Currency,
        'transfer': BankTransfer,
        'deposit': BankTransferIn,
        'withdrawal': BankTransferOut,
        'edit': Pencil
    },
    props: {
        transactionList: {
            type: Array,
            default: () => []
        },
        context: {
            type: String,
            default: 'bank'
        }
    },
    data() {
        return {

        };
    },
    computed: {
        ...mapState(['accounts']),
        ...mapState('categories', ['categoryList']),
        // ...mapGetters()
    },
    methods: {
        ...mapMutations('app', ['showModal', 'hideModal']),
        moment(d) {
            return moment.utc(d).local().format('ddd, MMM DD');
        },
        showTransactionModal() {
            this.showModal({
                modalId: 'transaction-modal',
                payload: {mode: "add"}
            });
        },
        getCategories(t) {
            return t.split.reduce((list, item) => {
                let cat = this.categoryList.find(cat => cat.id == item.categoryId);
                if (cat) {
                    if (('deposit' == t.type && 0 == list.length) || ('transfer' == t.type && list.length > 0) ) {
                        if ('transfer' == t.type) list += ', ';
                        list += 'To: ';
                    }
                    else if (('transfer' == t.type || 'withdrawal' == t.type) && 0 == list.length)
                        list += 'From: ';
                    else if (list.length > 0)
                        list += ', ';
                    list += cat.name;
                }
                return list;
            }, '');
        }
    },
    watch: {}
}
</script>

<style lang="scss">

    @import 'resources/sass/variables';

    #recent-transactions {
        .transfer {
            color: $purple;
        }
        .deposit {
            color: $green;
        }
        .withdrawal {
            color: $red;
        }

        table {
            width: 100%;

            tr {
                display: grid;
                grid-template-columns: 1fr min-content 90px;
                padding: 0 0.5rem;

                &:nth-child(even) {
                    background-color: $lightgray;
                }

                td {
                    &.date {
                        grid-column: 1/2;
                        font-size: .8em;
                        color: gray;
                    }
                    &.details {
                        grid-column: 1/2;
                    }
                    &.memo {
                        
                    }
                    &.name {

                    }
                    &.type {
                        grid-column: 2/3;
                        grid-row: 1/3;
                        justify-self: end;
                        align-self: center;
                    }
                    &.amount {
                        grid-column: 3/4;
                        grid-row: 1/3;
                        justify-self: end;
                        align-self: center;
                    }
                }
            }
        }
    }

</style>
