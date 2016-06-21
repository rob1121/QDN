import Vue from 'vue';
import { Multiselect } from 'vue-multiselect';
import { numeric } from './filter/numeric';

var VueValidator = require('vue-validator');
Vue.use(VueValidator);

Vue.filter('numeric', numeric);

new Vue({
    el: 'body',

    components: { Multiselect },

    data: {
        isCheck: false,
        selectedStation: null,
        selectedEmployee: null,
        selectedFailureMode: null,
        selectedDiscrepancyCategory: null,
        valid: true,

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
    }
});