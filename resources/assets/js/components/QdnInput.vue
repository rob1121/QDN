<template>
    <div v-show="show">
        <label>
            {{ label }}: <br/>
            <input type="text"
                   :name="name"
                   :id="name"
                   class="form__input"
                   :placeholder="placeholder"
                   v-model="input"
            >
        </label>
    </div>
</template>
<style lang="scss">
    $white: #ffffff;
    $border-color: #2D324F;
    $semi-white: lighten($border-color, 45%);

    .form__input {
        min-height: 44px;
        padding: 8px;
        margin-right: 10px;
        border-radius: 7px;
        border: 1px solid $border-color;
        background-color: $white;
        transition: .3s;

        &:focus {
            outline: none;
            box-shadow: 0px 0px 0px 1px $border-color
        }
    }
</style>
<script>
    export default{
        data(){
            return {
                msg: 'hello vue'
            }
        },

        props: {
            'name': {default: ''},
            'placeholder': {default: 'Require input'},
            'input': {default: ''},
            'label': {default: ''},
            'show': {default: true}
        }
    }
</script>
