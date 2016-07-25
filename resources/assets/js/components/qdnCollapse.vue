<template lang="jade">
{{ list.length }}
.box.h2.wow-reveal
	.panel.panel-primary(v-for="qdn in list")
		.panel-heading
			h3.panel-title {{ qdn.status }}
		.panel-body(v-bind:id="qdn.id") {{ qdn.count }} adasda asdad
		a.h5(href="#" @click.prevent="filterQdnByStatus(qdn.status)")
			.panel-footer(data-toggle="collapse" href="#{{ qdn.link }}" aria-expanded="false" aria-controls="{{ qdn.link }}")
				span View Details
					i.fa.fa-arrow-circle-right
				.clearfix


.collapse"(id="{{ qdn.link }}")
	.well
		legend {{ qdn.status }}
			table.table.table-hover#table-content
				thead
					tr
						th QDN No.
						th.col-md-5 Desciption
						th Station
						th Customer
						th Receiver
						th Timestamp
</template>
<style lang="stylus">
	.box
		display: flex
		align-content: center
		flex-direction: row
		width: 1200px
		align-items: space-around

		a
			text-decoration: none

		i.fa.fa-arrow-circle-right
			float: right

</style>
<script>
	export default {
		props: ['list'],

		methods: {
			filterQdnByStatus(status) {
				this.$http.get(link.getQdnLinkAndData, { param: { status: status } })
				.then(response => {
					console.log(response.json());
					this.baseTable = response.json();
				}).bind(this);
			}
		}
	}
</script>