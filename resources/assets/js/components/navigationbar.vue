<template lang="jade">
.nav__list
    li( v-bind:class="isActive('/')" )
        a( href="/" ) QDN

    li( v-bind:class="isActive(home)" )
        a( v-bind:href="home" ) home

    li( v-bind:class="isActive(issue_qdn)" )
        a( v-bind:href="issue_qdn" ) Issue qdn

    li
        img.profile__photo(src="/uploads/avatar/{{ user.avatar }}" alt="profile")
        {{ user.employee.name }} &nbsp;
        i.fa.fa-caret-up
        ul.dropdown
            li: a(href="#") Dashboard &nbsp;
                i.fa.fa-table.dropdown__icon

            li: a(href="#") Profile &nbsp;
                i.fa.fa-user.dropdown__icon

            li: a(href="#") Logout &nbsp;
                i.fa.fa-sign-out.dropdown__icon
</template>

<style lang="stylus">

li
    list-style: none

.nav__list
    position: fixed
    z-index: 1
    top: 0
    margin: 0
    padding: 0 90px
    color: #fff
    display: inline-block
    background: #660000
    width: 100%
    min-width: 600px
    box-shadow: 0 2px 2px 0 rgba(0, 0, 0, 0.5)

    &>li
        float: left
        padding: 10px 20px
        text-transform: uppercase
        color: darken(#fff, 20%)
        text-align: center
        transition: .3s ease-in-out

        &:hover
            background: lighten(#660000, 5%)
            color: #fff

        &:first-child
            float: left

        &:last-child
            float: right
            position: relative
            padding: 5px
            cursor: pointer

            .profile__photo
                width: 30px
                height: 30px
                border-radius: 50%
                border: 1px solid #fff
                margin-right: 10px

            i.fa.fa-caret-up
                transition: .1s ease-in-out

            &:hover .dropdown
                display: block

            &:hover i.fa.fa-caret-up
                transform: rotate(-180deg)

    a
        text-decoration: none
        text-align: center
        color: darken(#fff, 20%)
        transition: .3s ease-in-out

        &:hover
            color: #fff


.dropdown
    width: auto
    box-shadow: 0 2px 2px 0 rgba(0, 0, 0, 0.5)
    transition: .1s ease-in-out
    display: none
    padding: 0
    padding-top: 5px
    position: absolute
    top: 40px
    left: 0
    right: 0
    background: #fff
    color: #000
    overflow: hidden

    li
        padding-top: 5px
        padding-bottom: 5px
        padding-right: 10px
        padding-left: 5px
        text-align: left
        position: relative
        transition: .1s ease-in-out

        a
            color: #000

        .dropdown__icon
            opacity: 0
            transition: .3s ease-in-out

        &:hover
            background-color: lighten(#660000, 90%)

            a
                margin-left: 5px
                color: lighten(#000, 20%)

            .dropdown__icon
                opacity: 1

.active-link
    background: lighten(#660000, 5%)
    color: #fff


</style>

<script>
export default {
    props: ['user', 'home','issue_qdn','currentUrl'],

    methods: {
        isActive(url) {
            if (this.currentUrl == url) return "active-link";
        }
    }
}
</script>
