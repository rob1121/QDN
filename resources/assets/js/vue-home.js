import Vue from "vue";
import qdnCollapse from "./components/qdnCollapse.vue";

Vue.use(require('vue-resource'));

Vue.http.headers.common['X-CSRF-TOKEN'] = document.querySelector('#_token').getAttribute('content');

new Vue({
	el: "body",

	data: {
		baseTable: [],
		qdn: qdn
	},


	components:{ qdnCollapse },

	ready() {
		this.getQdnCount();
		setInterval(() => this.getQdnCount(), 60 * 1000);
	},

	methods: {
		getQdnCount() {
			this.$http.get(env_server + '/count')
				.then(reponse => this.updateCountStatus(reponse.data))
				.bind(this);
			},

		updateCountStatus(qdn) {
			$('#text-today').text(qdn.today);
			$('#text-week').text(qdn.week);
			$('#text-month').text(qdn.month);
			$('#text-year').text(qdn.year);
			$('#text-peVerification').text(qdn.PeVerification);
			$('#text-incomplete').text(qdn.Incomplete);
			$('#text-approval').text(qdn.Approval);
			$('#text-qaVerification').text(qdn.QaVerification);
		}
		}
});