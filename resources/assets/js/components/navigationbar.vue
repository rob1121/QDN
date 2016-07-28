<template lang="jade">
.nav__list
    li: a(href="#") QDN
    li: a(href="#") Home
    li: a(href="#") Issue Qdn
    li
        .dropdown__toggler Name
        ul.dropdown
            li: a(href="#")  Dashboard
            li: a(href="#")  Profile
            li: a(href="#")  Logout
</template>

<style lang="stylus">
li
    list-style: none

.nav__list
    position: fixed
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

            &:hover .dropdown
                display: block

    a
        text-decoration: none
        text-align: center
        color: darken(#fff, 20%)
        transition: .3s ease-in-out

        &:hover
            color: #fff

.dropdown
    box-shadow: 0 2px 2px 0 rgba(0, 0, 0, 0.5)
    transition: .1s ease-in-out
    display: none
    padding: 0
    padding-top: 5px
    position: absolute
    top: 40px
    margin-left: -20px
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

        &:hover
            background-color: darken(#ffffff, 10%)
            transform: translateX(3px)

        a
            color: #000

            &:hover
                color: lighten(#000, 20%)
</style>

<script>
    export default {}
</script>
