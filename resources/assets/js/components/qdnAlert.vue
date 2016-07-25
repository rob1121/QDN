<template lang="jade">
.error(v-show="list.length != 0" transition="fade")
    button.close(type="button" data-dismiss="alert") ×
    strong {{ class | uppercase}}
    li(v-for="(name, value) in list"): {{ name }}: {{ value }}
</template>

<style lang="scss">
.error {
	text-transform: capitalize;
	margin: 0px 20px;
	border-radius: 5px;
	background-color: lighten(darkred, 60%);
    padding: 20px 20px !important;

	li {
		padding: 15px auto;
		list-style: none;
	}

	.close {
		position: relative;
		right: -15px;
		top: -15px;
	}
}

.fade-transition {
	transition: .3s ease-in-out
}

.fade-enter {
	opacity: 1
}

.fade-leave {
	opacity: 0
}
</style>

<script>
	export default {
		props: ['list'],

		watch: {
			list() {
				setTimeout(() => this.list = [], 15000);
			}
		}
	}
</script>