<template>
    <div class="card" id="recent-transactions">

        <h2 class="card-header">Recent Transactions</h2> 

        <template v-if="accounts.loading">
            <div class="loader"></div>
        </template>

        <table v-else>
            <template class="transaction-grid"  v-for="transaction in transactionList.slice(0, 10)">
                <tr :key="'t-'+transaction.id">
                    <td>{{moment(transaction.createdAt.date)}}</td>
                    <td v-if="'bank' == context">
                        {{accounts.accountList.find( item => item.id == transaction.accountId).accountHolder.name}}
                    </td>
                    <!-- <td v-else-if="'account' == context">
                        categories?
                    </td> -->
                    <td>
                        <transfer v-if="transaction.type == 'transfer'" class="transfer"></transfer>
                        <deposit v-else-if="transaction.type == 'deposit'" class="deposit"></deposit>
                        <withdrawal v-else-if="transaction.type == 'withdrawal'" class="withdrawal"></withdrawal>
                    </td>
                    <td class="align-right">
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
        ...mapState(['accounts'])
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

            tr:nth-child(even) {
                background-color: $lightgray;
            }

            td {
                &.align-right {
                    text-align: right;
                }
            }

        }
    }

</style>
