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

    components: {
        Multiselect,
        'qdn-input': QdnInput
    },

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

        selected: {
            customer: null,
            station: null,
            employee: [],
            failureMode: null,
            discrepancyCategory: null
        },

        input: {
            customer: null,
            other_customer: null,
            device_name: null,
            lot_id_number: null,
            package_type: null,
            lot_quantity: null,
            problem_description: null,
            major: 'minor'
        },

        major: false,
        isCheck: false,
        valid: false
    },

    watch: {
        major: function () {
            var self = this;

            self.input.major = self.major == "true" ? "major" : "minor";

            self.setDiscrepancyCategoryByLevel();
        },

        isCheck: function () {
            var self = this;

            self.setDiscrepancyCategoryByLevel();
        },

        'selected.failureMode': function () {
            this.isValid();
        },

        'selected.customer': function (value) {
            this.setCustomerValue(value);
        },

        'selected.station': function () {
            this.isValid();
        },

        'selected.employee': function () {
            this.isValid();
        },

        'selected.discrepancyCategory': function () {
            this.isValid();
        },

        'input.customer': function () {
            this.isValid();
        },

        'input.other_customer': function () {
            this.isValid();
        },

        'input.device_name': function () {
            this.isValid();
        },

        'input.lot_id_number': function () {
            this.isValid();
        },

        'input.package_type': function () {
            this.isValid();
        },

        'input.lot_quantity': function () {
            this.isValid();
        },

        'input.problem_description': function () {
            this.isValid();
        }
    },

    methods: {
        setDiscrepancyCategoryByLevel: function () {
            var self = this;

            self.category.discrepanciesOption = self.category.discrepancies.map(function (arr) {
                if (self.major === arr['is_major'] && self.isCheck.toString() == arr['with_lot_involved']) {
                    return arr['name'];
                }
            }).filter(function (data) {
                return typeof data !== 'undefined';
            });
        },

        setCustomerValue: function (value) {
            var self = this;

            self.input.customer = value;

            if (value == "OTHERS") {
                self.input.customer = self.input.other_customer;
            }

            self.valid = false;
            self.valid = self.isRequiredFieldValid()
        },

        isRequiredFieldValid: function () {
            var self = this,
                required = self.selected.employee.length
                    && self.selected.station
                    && self.selected.failureMode
                    && self.selected.discrepancyCategory
                    && self.selected.customer
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

        isValid: function () {
            var self = this;

            self.valid = false;

            self.valid = self.isRequiredFieldValid()
        },

        saveQdn: function () {
            var self = this;

            self.$http.post('/report', self.input).then((response) => {
                console.log(response.data);
            });
        }
    }
});