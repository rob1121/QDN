<template>
    <div class="content">

        <div class="section">{{ title }}</div>
        <div class="group-content">

            <div class="label-collection"
                 transition="slide"
                 v-if="actions.length"
             >
                    <label class="label-set what">What</label>

                    <label class="label-set">who</label>

                    <label class="label-set">when</label>
            </div>

            <div v-for="action in actions"
                 transition="slide"
                 class="input-collection"
            >
                <div class="input-set what">
                    <input  type="text"
                            class="what"
                            name="{{ names.whatname }}[]"
                            v-model="action.what"
                            placeholder="what"
                    >
                </div>

                <div class="input-set">
                    <input  type="text"
                            class="who"
                            name="{{ names.whoname }}[]"
                            v-model="action.who"
                            placeholder="who"
                    >
                </div>

                <div class="input-set">
                    <input  type="text"
                            class="when"
                            name="{{ names.whenname }}[]"
                            v-model="action.when"
                            placeholder="when"
                    >
                </div>

                <a href="#" @click.prevent="removeAction(action)">
                    <i class="fa fa-close remove-btn"></i>
                </a>
            </div>

            <button class="add-btn"
                    @click="addAction"
                    v-show="actions.length < 5"
                    transition="slide"
            > Add new <i class="fa fa-plus"></i>
            </button>
        </div>
    </div>
</template>

<style lang="scss">
    $border-color: #2D324F;
    @mixin shadow() {
        box-shadow: 0px 1px 5px 0px lighten($border-color, 20%);
    }

    * {
        margin: 0;
        padding: 0;
        outline: none;
    }

    .add-btn {
        font-weight: bold;
        min-height: 30px;
        margin: 10px 5px;
        padding: 4px 8px;
        color: #fff;
        background-color: $border-color;
        float: right;
        transition: .3s;
        @include shadow();
        border: 1px solid darken($border-color, 10%);
        border-radius: 5px;

        &:hover {
            background-color: lighten($border-color, 10%);
            box-shadow: 0px 3px 5px 0px lighten($border-color, 20%);
        }

    }

    .remove-btn {
        background-color: #fff;
        position: absolute;
        right: 0;
        top: 0;
        margin-top: -5px;
        margin-right: -11px;
        border-radius: 50%;
        padding: 1px;
        color: lighten(firebrick, 10%);
        transition: all .1s ease-in-out;

        &:hover {
            transform: scale(1.2);
            color: firebrick;
        }
    }

    .content {
        overflow: hidden;
        display: flex;
        align-items: center;
        flex-direction: column;
    }

    .group-content {
        min-width: 700px;
        width: 80vw;
        background: #fff;
        border: 1px solid $border-color;
        border-top: 0px;
        padding: 30px 20px;
        overflow: hidden;
    }

    .section {
        border: 1px solid $border-color;
        border-top: 0px;
        padding: 8px;
        min-width: 700px;
        margin: 0px;
        width: 80vw;
        text-transform: uppercase;
        background: #800000;
        color: #fff;
        font-size: 14px;
    }

    .input-collection {
        padding: 3px 0;
        display: flex;
        min-width: 300px;
        border-radius: 5px;

        .input-set {
            padding: 0px 5px;
            width: 220px;
        }

        .what {
            flex-grow: 3;
        }

        input {
            transition: all .2s ease-in-out;
            border-radius: 5px;
            border: 1px solid $border-color;
            padding: 5px 10px;
            width: 100%;

            &:focus {
            box-shadow: 0px 0px 0px 1px $border-color;
            }
        }
    }

    button {
        display: block;
    }

    .slide-transition {
        position: relative;
    }

    .slide-enter {
        animation: enterTransition;
        animation-duration: .7s;
    }

    .slide-leave {
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



    .label-collection {
        display: flex;

        .label-set {
            text-align: center;
            font-weight: bold;
            padding: 0px 5px;
            width: 220px;
        }

        .what {
            flex-grow: 3;
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
