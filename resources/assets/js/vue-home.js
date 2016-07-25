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
});