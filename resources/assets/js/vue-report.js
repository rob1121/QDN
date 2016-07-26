import Vue from 'vue';
import formSection from './components/section.vue';
import formCheckBox from './components/set-of-checkbox.vue';

new Vue({
    el: 'body',
    data: {
        section1: [
            {name: 'customer', value: qdn.customer},
            {name: 'package type', value: qdn.package_type},
            {name: 'device name', value: qdn.device_name},
            {name: 'lot quantity', value: qdn.lot_quantity},
            {name: 'lot ID no.', value: qdn.lot_id_number},
        ],

        section2: [
            {name: 'Job  Number No', value: qdn.job_or_no},
            {name: 'Machine', value: qdn.machine},
            {name: 'station', value: qdn.station},
            {name: 'major', value: qdn.major},
            {name: 'minor', value: qdn.minor},
        ],

        section3: [
            {name: 'QDN #', value: qdn.control_id},
            {name: 'Team/Resp.', value: qdn.InvolvePerson},
            {name: 'Issued By (Name/Emp #)', value: qdn.InvolvePerson},
            {name: 'Issued To (Name/Emp #)', value: qdn.InvolvePerson},
            {name: 'Date/Time', value: qdn.created_at},
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

    components: { formSection, formCheckBox },

    filters: {
        list() {

        }
    }
});