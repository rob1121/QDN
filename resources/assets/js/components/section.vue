<template>
    <div class="content">
        <div class="group-content">

            <h1>{{ title }}</h1>

            <div v-for="action in actions"
                 transition="bounce"
                 class="input-collection"
            >
                <div class="input-set what">
                    <label>What</label>
                    <input  type="text"
                            class="what"
                            name="{{ names.whatname }}[]"
                            v-model="action.what"
                            placeholder="what"
                    >
                </div>

                <div class="input-set">
                    <label>Who</label>
                    <input  type="text"
                            class="who"
                            name="{{ names.whoname }}[]"
                            v-model="action.who"
                            placeholder="who"
                    >
                </div>

                <div class="input-set">
                    <label>When</label>

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
                    transition="bounce"
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
        margin-top: -15px;
        margin-right: -12px;
        transition: all .1s ease-in-out;
        border: 1px solid $border-color;
        border-radius: 50%;
        padding: 1px;
        font-size: 24px;
        color: $border-color;

        &:hover {
            color: firebrick;
            @include shadow();
            transform: scale(1.1);
        }
    }

    .content {
        overflow: hidden;
        display: flex;
        align-items: center;
        flex-direction: column;
    }

    .group-content {
        width: 80vw;
    }

    .input-collection {
        background-color: #fff;
        @include shadow();
        border: 1px solid $border-color;
        margin-bottom: 15px;
        padding: 3px 0;
        display: flex;
        min-width: 300px;
        justify-content: space-around;
        border-radius: 5px;

        .input-set {
            padding: 0px 5px;

            &.what {
                flex-grow: 3;
            }

            label {
                display:block;
                text-align: center;
                font-weight: bold;
            }
        }

        input {
            transition: all .1s ease-in-out;
            border-radius: 5px;
            border: 1px solid $border-color;
            padding: 5px;
            width: 100%;

            &:hover, &:focus {
                @include shadow();
            }
        }
    }

    @media (max-width: 700px) {
        input {
            background-color: #333333;
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
