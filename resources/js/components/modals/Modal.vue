<template>
    <div class="dialog" :id="id" v-if="showModals[id]">
        <header>
            <span class="title">{{modalTitle}}</span>
            <button v-on:click="handleCancel">X</button>
        </header>
        <div class="content">
            <slot></slot>
        </div>
        <footer>
            <button v-on:click="handleCancel">{{cancelText}}</button>
            <button v-on:click="handleClick">{{clickText}}</button>
        </footer>
    </div>
</template>

<script>
import {mapState, mapGetters, mapActions, mapMutations} from 'vuex';

export default {
    props: {
        id: {
            type: String,
            default: ''
        },
        modalTitle: {
            type: String,
            default: ''
        },
        clickText: {
            type: String,
            default: 'Save'
        },
        cancelText: {
            type: String,
            default: 'Cancel'
        },
    },
    computed: {
        ...mapState('app', ['showModals', 'modalPayload']),
    },
    methods: {
            ...mapMutations('app', ['registerModal', 'showModal', 'hideModal']),
            handleClick() {
                // this.disabled = true;
                this.$emit('handle-modal-click');
            },
            handleCancel() {
                // this.disabled = true;
                this.$emit('handle-modal-cancel');
            },
            handleClose() {
                // this.disabled = true;
                this.$emit('handle-modal-close');
            },
    },
    mounted() {
        console.log('Modal.vue mounted')
        this.registerModal(this.id);
    }
}
</script>

<style lang="scss">
    .dialog {
        box-sizing: border-box;
        position: fixed;
        top: 16px;
        min-width: 288px;
        max-width: 400px;
        padding: 0;
        background: pink;
        border: none;
        box-shadow: 0 0 5px 5px rgba(100, 100, 100, .3);
        left: 50%;
        transform: translateX(-50%);
        z-index: 100;

        header {
            display: flex;
            flex-flow: row nowrap;
            justify-content: space-between;
            border-bottom: 1px solid gray;
            padding: 16px;

            .title {
                text-transform: capitalize;
            }
        }
        .content {
            padding: 16px;
            // overflow-y: auto;
            min-height: 100px;
            max-height: calc(100vh - 150px);
        }
        footer {
            display: flex;
            flex-flow: row nowrap;
            justify-content: space-around;
            border-top: 1px solid gray;
            padding: 16px;
        }
    }
</style>