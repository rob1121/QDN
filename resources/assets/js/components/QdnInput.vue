<template>
        <label  v-show="show">
            {{ label }}: <br/>
            <input type="text"
                   :name="name"
                   :id="name"
                   class="form__input"
                   :placeholder="placeholder"
                   v-model="input"
            >
        </label>
</template>
<style lang="scss">
    $white: #ffffff;
    $border-color: #2D324F;
    $semi-white: lighten($border-color, 45%);

    .form__input {
        min-width: 254px;
        height: 40px;
        padding: 8px;
        margin-right: 8px;
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
    export default {
        props: {
            'name': {default: ''},
            'placeholder': {default: 'Require input'},
            'input': {default: ''},
            'label': {default: ''},
            'show': {default: true}
        }
    }
</script>
