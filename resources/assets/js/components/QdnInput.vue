<template>
    <div v-show="show">
        <label>
            {{ label }}: <br />
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
    $light-green-border: #41B883;
    $semi-white:lighten($light-green-border, 45%);

    .form__input {
        min-height: 44px;
        padding: 8px;
        margin-right: 10px;
        border: 2px solid $light-green-border;
        background-color: $white;
    }
</style>
<script>
    export default{
        data(){
            return{
                msg:'hello vue'
            }
        },

        props: {
            'name': { default: '' },
            'placeholder': { default: 'Require input' },
            'input': { default: '' },
            'label': { default: '' },
            'show': { default: true }
        }
    }
</script>
