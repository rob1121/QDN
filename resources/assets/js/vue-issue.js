import Vue from 'vue';
import { Multiselect } from 'vue-multiselect';

var Vue = require('vue')
var VueValidator = require('vue-validator')

Vue.use(VueValidator)

new Vue({
    el: 'body',

    components: { Multiselect },

    data: {
        isCheck: false,
        selectedStation: null,
        selectedEmployee: null,
        selectedFailureMode: null,
        selectedDiscrepancyCategory: null,

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

Vue.transition('fade', {
    enterClass: 'fadeIn',
    leaveClass: 'fadeOut'
});