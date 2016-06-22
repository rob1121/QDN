import Vue from 'vue';
import QdnInput from './components/QdnInput.vue';
import { Multiselect } from 'vue-multiselect';
import { numeric, filterDiscrepancyCategory } from './filter/filters';

var VueValidator = require('vue-validator');
Vue.use(VueValidator);

Vue.filter('numeric', numeric);
Vue.filter('filterDiscrepancyCategory', filterDiscrepancyCategory);

new Vue({
    el: 'body',

    components:
    {
        Multiselect,
        'qdn-input': QdnInput
    },

    data:
    {
        selected:
        {
            customer: null,
            station: null,
            employee: [],
            failureMode: null,
            discrepancyCategory: null
        },

        category:
        {
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
            machines: machines
        },

        input:
        {
            customer: '',
            other_customer: '',
            device_name: '',
            lot_id_number: '',
            package_type: '',
            lot_quantity: '',
            problem_description: ''
        },

        major: false,
        isCheck: false,
        valid: true,
        discrepanciesOption: []
    },
    
    watch:
    {
        major: function ()
        {
            var self = this;

            self.discrepanciesOption = self.getDiscrepancyCategoryByLevel();
        },

        isCheck: function ()
        {
            var self = this;

            self.discrepanciesOption = self.getDiscrepancyCategoryByLevel();
        }
    },

    methods:
    {
        getDiscrepancyCategoryByLevel: function ()
        {
            var self = this;

            return self.category.discrepancies.map(function (arr)
            {
                if (self.major === arr['is_major'] && self.isCheck.toString() == arr['with_lot_involved'])
                {
                    return arr['name'];
                }
            }).filter(function (data)
            {
                return typeof data !== 'undefined';
            });
        }
    }
});