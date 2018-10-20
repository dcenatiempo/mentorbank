<template>
    <money
        v-model="dataPrice"
        v-bind="money"></money>
</template>
 
<script>
    import {Money} from 'v-money'
    
    export default {
        components: {Money},
        props: {
            dataIndex: Number,
            price: Number
        },
        data () {
            return {
                dataPrice: 0,
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
                console.log('changing amount!')
                debugger
                let payload = {
                    index: this.dataIndex,
                    price: this.dataPrice
                };
                this.$emit('change', payload)
            },
            reset() {
            }
        },
        watch: {
            // price(val) {
            //     this.dataPrice = val;
            // }
        }
    }
</script>

<style>
    .v-money {
        text-align: right;
    }
</style>
