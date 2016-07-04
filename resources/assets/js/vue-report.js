import Vue from 'vue';
import formSection from './components/section.vue';
import formCheckBox from './components/set-of-checkbox.vue';

new Vue({
    el: 'body',
    data: {
        section1: [
            {name: 'customer', value: '[data]'},
            {name: 'package type', value: '[data]'},
            {name: 'device name', value: '[data]'},
            {name: 'lot quantity', value: '[data]'},
            {name: 'lot ID no.', value: '[data]'},
        ],

        section2: [
            {name: 'Job  Number No', value: '[data]'},
            {name: 'Machine', value: '[data]'},
            {name: 'station', value: '[data]'},
            {name: 'major', value: '[data]'},
            {name: 'minor', value: '[data]'},
        ],

        section3: [
            {name: 'QDN #', value: '[data]'},
            {name: 'Team/Resp.', value: '[data]'},
            {name: 'Issued By (Name/Emp #)', value: '[data]'},
            {name: 'Issued To (Name/Emp #)', value: '[data]'},
            {name: 'Date/Time', value: '[data]'},
        ],

        containmentAction: [{ what: '', who: '', when: '' }],
        correctiveAction: [{ what: '', who: '', when: '' }],
        preventiveAction: [{ what: '', who: '', when: '' }],
        cod_value: null,
        dispo_value: null,

        cod_radios: [
            'production',
            'process',
            'maintenance',
            'facilities',
            'quality assurance',
            'others'
        ],

        dispo_radios: [
            'use as is',
            'NCMR #',
            'rework',
            'split lot',
            'shutdown',
            'shipback'
        ],

        cnNames: { whatname: 'cnAction', whoname: 'cnWho', whenname: 'cnWhen' },
        caNames: { whatname: 'caAction', whoname: 'caWho', whenname: 'caWhen' },
        paNames: { whatname: 'paAction', whoname: 'paWho', whenname: 'paWhen' },

        departmentList: ['production', 'process', 'quality assurance', 'other department']
    },

    components: { formSection, formCheckBox }
});