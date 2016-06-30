import Vue from 'vue';
import Section from './components/section.vue';

new Vue({
    el: 'body',
    data: {
        containmentAction: [{ what: '', who: '', when: '' }],
        correctiveAction: [{ what: '', who: '', when: '' }],
        preventiveAction: [{ what: '', who: '', when: '' }],

        cnNames: { whatname: 'cnAction', whoname: 'cnWho', whenname: 'cnWhen' },
        caNames: { whatname: 'caAction', whoname: 'caWho', whenname: 'caWhen' },
        paNames: { whatname: 'paAction', whoname: 'paWho', whenname: 'paWhen' }
    },

    components: { 'form-section': Section }
});