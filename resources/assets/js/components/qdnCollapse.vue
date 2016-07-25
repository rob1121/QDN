<template lang="jade">
.box.h2.wow-reveal
	.panel.panel-primary(v-for="qdn in list")
		.panel-heading
			h3.panel-title {{ qdn.status }}
		.panel-body(v-bind:id="qdn.id") {{ qdn.count }}
		a.h5(href="#" @click.prevent="filterQdnByStatus(qdn.status)")
			.panel-footer(href="#{{ qdn.link }}")
				span View Details
					i.fa.fa-arrow-circle-right
				.clearfix


.well(v-show="isShow")
	legend {{ status | capitalize }}
		table.table.table-hover#table-content
			thead
				tr
					th QDN No.
					th.col-md-5 Desciption
					th Station
					th Customer
					th Receiver
					th Timestamp
			tbody
				tr(v-for="qdn in baseTable" v-if="baseTable.length > 0")
					td {{ qdn.gate ? qdn.url + qdn.info.control_id : "(is active at the moment)" }}
					td {{ qdn.info.problem_description }}
					td {{ qdn.info.station }}
					td {{ qdn.info.customer }}
					td
						li(v-for="person in qdn.receiver_name") {{ person.receiver_name }}
					td {{ qdn.info.created_at | diffFromNow }}

				tr(v-if="baseTable.length == 0")
					td.row-empty(colspan="6") No data to display
</template>

<style lang="stylus">
.well
	box-shadow: 0 3px 5px 0px rgba(0, 0, 0, 0.5)

.box
	margin: 0 auto
	display: flex
	align-content: center
	flex-direction: row
	justify-content: space-around
	flex-wrap: wrap

	.panel
		min-width: 250px
		box-shadow: 0 3px 5px 0px rgba(0, 0, 0, 0.5)

	a
		text-decoration: none

	i.fa.fa-arrow-circle-right
		float: right

tr
	font-size: 14px

	>th
		font-weight: bold

	.row-empty
		text-align: center


	li
		list-style: none

</style>
<script>
import moment from "moment";

	export default {
		data() {
			return {
				baseTable: [],
				isShow: false,
				status: null
			}
		},

		props: ['list'],

		filters: {
			diffFromNow(value) {
				return moment(value).fromNow();
			}
		},

		methods: {
			filterQdnByStatus(status) {
				if (this.toRefresh(status)) {
					this.$http.get("/status?status=" + status.toLowerCase() )
					.then(response => {
						this.baseTable = response.data;
						this.status = status;
					},
						response => console.log("Error: " + response.data))
					.bind(this);
				}

				this.toggleTable(status);
			},

			toRefresh(status) {
				return ! (status == this.status && this.isShow == true);
			},

			toggleTable(status) {
				return this.isShow = (status == this.status) ? ! this.isShow : true;
			}
		}
	}
</script>