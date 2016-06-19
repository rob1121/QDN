import Vue from 'vue';
import { Multiselect } from 'vue-multiselect'

new Vue({
    el: 'body',

    components: { Multiselect },

    data:{

        selected: null,
        options: ['list', 'of', 'options'],

        customer: customers,
        stations: stations,
        discrepancies: discrepancies,
        machines: machines
    },
});