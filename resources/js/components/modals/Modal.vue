<template>
    <div class="dialog" :id="id" v-if="showModals[id]">
        <header>
            <span class="title">{{modalTitle}}</span>
            <button class="btn-icon" v-on:click="handleCancel"><close></close></button>
        </header>
        <div class="content">
            <slot></slot>
        </div>
        <footer>
            <button class="btn-cancel" v-on:click="handleCancel">{{cancelText}}</button>
            <button class="btn-confirm" v-on:click="handleClick" :disabled="disabled">{{clickText}}</button>
        </footer>
    </div>
</template>

<script>
import {mapState, mapGetters, mapActions, mapMutations} from 'vuex';
import Close from 'icons/Close'

export default {
    components: { Close },
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
        disabled: {
            type: Boolean,
            default: false
        }
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
        this.registerModal(this.id);
    }
}
</script>

<style lang="scss">
    @import 'resources/sass/variables';

    .dialog {
        box-sizing: border-box;
        position: absolute;
        top: 16px;
        min-width: 288px;
        max-width: 400px;
        padding: 0;
        margin-bottom: 1rem;
        background: white;
        border: none;
        border-radius: 5px;
        box-shadow: 0 0 5px 5px rgba(100, 100, 100, .3);
        left: 50%;
        transform: translateX(-50%);
        z-index: 100;

        header {
            display: flex;
            flex-flow: row nowrap;
            justify-content: space-between;
            border-bottom: 1px solid $lightgray;
            padding: 16px;

            .title {
                text-transform: capitalize;
                font-size: 1.2rem;
            }
        }
        .content {
            padding: 16px;
            // overflow-y: auto;
            min-height: 100px;
            // max-height: calc(100vh - 150px);
        }
        footer {
            display: flex;
            flex-flow: row nowrap;
            justify-content: space-around;
            border-top: 1px solid $lightgray;
            padding: 16px;
        }
    }
</style>