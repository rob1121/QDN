<template lang="jade">
.box.h2
	.panel.panel-primary(v-for="qdn in list")
		.panel-heading
			h3.panel-title {{ qdn.status }}
		.panel-body(:id="qdn.id") {{ qdn.count }}
		a.h5(href="#" @click.prevent="filterQdnByStatus(qdn.status)")
			.panel-footer(href="#{{ qdn.link }}")
				span View Details
					i.fa.fa-arrow-circle-right
				.clearfix

.well(v-show="isShow")
	.loader
		pulse-loader(:loading="isLoading" color="#800000" size="25px")

	legend {{ status | capitalize }}
		table.table.table-hover#table-content(v-show="! isLoading")
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
					td
						{{{ qdn.action_link }}}

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

#link
	margin-bottom: 32px

	div
		margin: 0px
		padding: 0px

	.row
		margin-top : 5px
		margin-left : 5px
		margin-row : 5px

.modal-body
	padding-top: 0px
	padding-bottom: 0px

.table
	background-color: #fff
	margin-bottom: 0px
	padding-top: 0px
	padding-bottom: 0px

.panel-primary>.panel-heading
	background-color: #800

.panel
	border: 0px

	.panel-primary,
	.panel-body,
	.panel-heading,
	.panel-footer
		border-radius: 0px
		border: 0px

.well
	margin: 0 auto
	box-shadow: 0 3px 5px 0px rgba(0, 0, 0, 0.5)
	background-color: #fff
	border: 1px solid #e3e3e3
	border-radius: 0px
    position: relative
    z-index: 1

.loader
    position: absolute
    z-index: 2
    top: 0
	bottom: 0
	left: 0
	right: 0
	display: block
	background-color: #222

.box
	display: flex
	align-content: center
	flex-direction: row
	justify-content: space-between
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
import { PulseLoader } from 'vue-spinner/dist/vue-spinner.min.js';

	export default {
		data() {
			return {
				baseTable: [],
				isShow: false,
				isLoading: false,
				status: null
			}
		},

		props: ['list'],

		filters: {
			diffFromNow(date) {
				return moment(date).fromNow();
			}
		},
		components: { PulseLoader },

		methods: {
			filterQdnByStatus(status) {
				this.isLoading = true;
				if (this.toRefresh(status)) {
					this.$http.get("/status?status=" + status.toLowerCase() )
					.then(response => {
						this.baseTable = response.data;
						this.status = status;
						this.isLoading = false;
					}, response => console.log("Error: " + response.data) )
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