<template>
    <span class="currency">
        {{formattedAmount}}
    </span>
</template>
 
<script> 
    export default {
        props: {
            amount: {
                type: Number,
                default: 0
            }
        },
        data () { return {}; },
        computed: {
            formattedAmount() {
                let formatter = new Intl.NumberFormat('en-US', {
                    style: 'currency',
                    currency: 'USD',
                    minimumFractionDigits: 2,
                });
                return formatter.format(this.amount);
            }
        },
    }
</script>

<style>

</style>
