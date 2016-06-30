<template>
    <div class="content">
        <div class="group-content">
            <h1>{{ title }}</h1>

            <div v-for="action in actions"
                 transition="bounce"
                 class="input-collection"
            >
                <div class="input-set">
                    <label>What</label>
                    <input  type="text"
                            name="{{ names.whatname }}[]"
                            v-model="action.what"
                            placeholder="what"
                    >
                </div>

                <input  type="text"
                        name="{{ names.whoname }}[]"
                        v-model="action.who"
                        placeholder="who"
                >

                <input  type="text"
                        name="{{ names.whenname }}[]"
                        v-model="action.when"
                        placeholder="when"
                >

                <a href="#" @click.prevent="removeAction(action)">
                    <i class="fa fa-close" style="color:firebrick"></i>
                </a>
            </div>

            <button
                    @click="addAction"
                    v-show="actions.length < 5"
                    transition="bounce"
            > Add new
            </button>
        </div>
    </div>
</template>

<style lang="scss">

    .content {
        overflow: hidden;
        display: flex;
        justify-content: center;
        align-items: center;
        flex-direction: column;
    }

    .input-collection {
        margin-bottom: 3px;
        display: flex;
        flex-wrap: wrap;

        input {
            &:nth-of-type(1) {
                flex-grow: 11;
            }
        }
    }

    button {
        display: block;
    }

    .bounce-transition {
        position: relative;
    }

    .bounce-enter {
        animation: enterTransition;
        animation-duration: .7s;
    }

    .bounce-leave {
        animation: leaveTransition;
        animation-duration: .7s;
    }

    @keyframes enterTransition {
        from {
            opacity:0;
            left: 10px;
        }

        to {
            opacity:1;
            left: 0px;
        }
    }

    @keyframes leaveTransition {
        from {
            opacity:1;
            left: 0px;
        }

        to {
            opacity:0;
            left: 10px;
        }
    }
</style>

<script>
    export default{
        data(){
            return {
                show: true,
                transition: 'enter'
            }
        },

        props: {
            actions: {
                default: {
                    who: '',
                    when: '',
                    what: ''
                }
            },
            names: {
                default: {
                    whoname: "who",
                    whenname: "when",
                    whatname: "what"
                }
            },

            title
        },

        methods: {
            addAction: function () {
                var self = this;
                if(self.actions.length < 5) {
                    self.actions.push({ what: '', who: '', when: '' });
                }
            },

            removeAction: function (action) {
                this.actions.$remove(action);
            }
        }
    }
</script>
