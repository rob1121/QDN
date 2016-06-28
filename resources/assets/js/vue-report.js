import Vue from 'vue';

new Vue({
    el: 'body',
    data: {
        correctiveAction: [{ what: '', who: '', when: '' }]
    },
    methods: {
        addAction: function () {
            this.correctiveAction.push({ what: '', who: '', when: '' });
        },
        
        removeAction: function (action) {
            this.correctiveAction.$remove(action);
        }
    }
});