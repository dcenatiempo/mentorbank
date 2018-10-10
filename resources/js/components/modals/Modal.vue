<template>
    <div class="modal">
        <h1>This is a modal</h1>
        <slot></slot>
        <div class="footer">
            <button>close</button>
            <button>save</button>
        </div>
    </div>
</template>

<script>
    export default {
        mounted() {
            console.log('Modal.vue mounted')
        }
    }
</script>

<style>
    div.modal {
        position: fixed;
        height: 200px;
        width: 200px;
        background: pink;
    }
</style>