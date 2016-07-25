import Vue from 'vue';
import QdnInput from './components/QdnInput.vue';
import {Multiselect} from 'vue-multiselect';
import qdnAlert from "./components/qdnAlert.vue";
import {numeric, filterDiscrepancyCategory} from './filter/filters';

var VueResource = require('vue-resource');

Vue.use(VueResource);

Vue.http.headers.common['X-CSRF-TOKEN'] = document.querySelector('#_token').getAttribute('value');
//================================= VUE FILTERS ===================
Vue.filter('numeric', numeric);
Vue.filter('filterDiscrepancyCategory', filterDiscrepancyCategory);

//================================= VUE INSTANCE ===================
new Vue({
    el: 'body',

    components: { Multiselect, QdnInput, qdnAlert },

    data: {
        category: {
            failureMode: [
                'assembly',
                'environment',
                'machine',
                'man',
                'material',
                'method / process'
            ],

            customers: customers,
            stations: stations,
            discrepancies: discrepancies,
            employees: employees,
            machines: machines,
            discrepanciesOption: []
        },

        input: {
            device_name: 'N/A',
            lot_id_number: 'N/A',
            package_type: 'N/A',
            lot_quantity: 0,
            receiver_name: [],
            other_customer: null,
            problem_description: null,
            major: 'minor',
            customer: null,
            station: null,
            machine: null,
            failure_mode: null,
            discrepancy_category: null
        },

        error: [],

        major: false,
        isCheck: false,
    },

    watch: {
        major() {
            this.input.major = this.major == "true" ? "major" : "minor";

            this.setDiscrepancyCategoryByLevel();
        },

        isCheck(value) {
            this.input.package_type = value ? null : 'N/A';
            this.input.device_name = value ? null : 'N/A';
            this.input.lot_id_number = value ? null : 'N/A';
            this.input.lot_quantity = value ? null : 0;
            this.setDiscrepancyCategoryByLevel();
        },

        'input.customer'(value) {
            this.setCustomerValue(value);
        },
    },

    methods: {
        setDiscrepancyCategoryByLevel() {
            var self = this;

            self.category.discrepanciesOption = self.category.discrepancies.map(function (arr) {
                if (self.major === arr['is_major'] && self.isCheck.toString() == arr['with_lot_involved']) {
                    return arr['name'];
                }
            }).filter(function (data) {
                return typeof data !== 'undefined';
            });
        },

        setCustomerValue(value) {
            this.input.customer = value;
            if (value == "OTHERS")
                this.input.customer = this.input.other_customer;
        },

        saveQdn() {
            this.$http.post('/report', this.input)
                .then(response => {
                    location.href = "/home/success";
                }, response => {
                    this.error = response.data;
                    window.scrollTo(0, 0);
                }).bind(this);
        }
    }
});