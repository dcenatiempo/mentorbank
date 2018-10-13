<template>
    <money
        v-model="price"
        v-bind="money"
        v-on:input="changeAmount"></money>
</template>
 
<script>
    import {Money} from 'v-money'
    
    export default {
        components: {Money},
        data () {
            return {
                price: 0,
                money: {
                    decimal: '.',
                    thousands: ',',
                    prefix: '$ ',
                    suffix: '',
                    precision: 2,
                    masked: false
                }
            }
        },
        methods: {
            changeAmount() {
                this.$emit('change', this.price)
            },
            reset() {
            this.price = 0;
        }
        }
    }
</script>

<style>
    .v-money {
        text-align: right;
    }
</style>
