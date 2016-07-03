import Vue from 'vue';
import QdnInput from './components/QdnInput.vue';
import {Multiselect} from 'vue-multiselect';
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

    components: { Multiselect, QdnInput },

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

        error: null,

        major: false,
        isCheck: false,
        valid: false
    },

    watch: {
        major() {
            var self = this;

            self.input.major = self.major == "true" ? "major" : "minor";

            self.setDiscrepancyCategoryByLevel();
        },

        isCheck(value) {
            var self = this;

            self.input.package_type = value ? null : 'N/A';
            self.input.device_name = value ? null : 'N/A';
            self.input.lot_id_number = value ? null : 'N/A';
            self.input.lot_quantity = value ? null : 0;
            self.setDiscrepancyCategoryByLevel();
        },

        'input.failure_mode'() {
            this.isValid();
        },

        'input.customer'(value) {
            this.setCustomerValue(value);
        },

        'input.station'() {
            this.isValid();
        },

        'input.machine'() {
            this.isValid();
        },

        'input.receiver_name'() {
            this.isValid();
        },

        'input.discrepancy_category'() {
            this.isValid();
        },

        'input.customer'() {
            this.isValid();
        },

        'input.other_customer'() {
            this.isValid();
        },

        'input.device_name'() {
            this.isValid();
        },

        'input.lot_id_number'() {
            this.isValid();
        },

        'input.package_type'() {
            this.isValid();
        },

        'input.lot_quantity'() {
            this.isValid();
        },

        'input.problem_description'() {
            this.isValid();
        }
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
            var self = this;

            self.input.customer = value;

            if (value == "OTHERS") {
                self.input.customer = self.input.other_customer;
            }

            self.valid = false;
            self.valid = self.isRequiredFieldValid()
        },

        isRequiredFieldValid() {
            var self = this,
                required = self.input.receiver_name.length
                    && self.input.station
                    && self.input.machine
                    && self.input.failure_mode
                    && self.input.discrepancy_category
                    && self.input.customer
                    && self.input.problem_description;

            if (self.isCheck) {
                return required
                    && self.input.device_name
                    && self.input.lot_id_number
                    && self.input.package_type
                    && self.input.lot_quantity
            }

            return required;

        },

        isValid() {
            var self = this;

            self.valid = false;

            self.valid = self.isRequiredFieldValid()
        },

        saveQdn() {
            var self = this;

            self.$http.post('/report', self.input)
                .then(response => {
                    if (! response.includes('already')) location.href = "/home/success";

                    self.error = response;
                    setTimeout(() => self.error = null, 15000);
                });
        }
    }
});