
var machineTable = new Vue({
    el: 'body',
    data: {
        newMachine: '',
        machines: machines,
        searchKey: '',
        reverse: 1,
        sortKey: '',
        currentPage: 0,
        itemsPerPage: 5,
    },

    computed: {
        lastPoint: function() {
            var val = this.currentPage;
            var last = this.totalPages - 1;

            if (val < 2) return val ? 5 - val : 4;
            if ((last - val) < 2) return last;
            return val + 2;
        },

        firstPoint: function() {
            var val = this.currentPage;
            var last = this.totalPages - 1;
            var res = last - val;

            if (val < 2) return 0;
            if (res < 2) return res ? last - (5 - res) : last - 4;
            return val - 2;
        },

        totalPages: function() {
            return Math.ceil(this.resultCount / parseInt(this.itemsPerPage))
        },

        resultCount: function() {
            this.currentPage = 0; //return to first page
            var filter = Vue.filter('filterBy');
            return filter(this.machines, this.searchKey).length;
        }
    },
    filters: {
        paginate: function(list) {
            var index = this.currentPage * parseInt(this.itemsPerPage)
            return list.slice(index, index + parseInt(this.itemsPerPage))
        },
    },
    methods: {

        sortBy: function(column) {
            this.sortKey = column;
            this.reverse = this.sortKey == column ? this.reverse * -1 : this.reverse = 1;
        },

        setPage: function(pageNumber) {
            this.currentPage = pageNumber
        },
        addMachine: function(name) {
            this.machines.push({
                name: name
            });
        },
        removeMachine: function(machine) {
            this.removeMachineTable(machine);
            this.alertMsg('Changes Saved!', 'Machine table are now updated', 'fa-save', 'ok');
        },
        editMachine: function(machine) {
            name = this.newMachine.trim();
            if (name) {
                this.updateMachineTable(name);
            }
            this.newMachine = machine.name;
            this.removeMachineTable(machine);
        },
        updateTable: function() {
            var name = this.newMachine.trim();
            if (name) {
                this.updateMachineTable(name);
                this.newMachine = '';
            }
        },
        updateMachineTable: function(name) {
            $.ajax({
                url: links.updateMachineOptions,
                type: 'get',
                data: {
                    name: name
                },
                success: function(data) {
                    if (data == 'unique') {
                        machineTable.addMachine(name);
                        machineTable.alertMsg('Changes Saved!', 'Machine table are now updated', 'fa-save', 'ok');
                    } else {
                        machineTable.alertMsg('Warning!', 'Machine already exist', 'fa-chain-broken', 'yellow');
                    }
                }
            });
        },
        removeMachineTable: function(machine) {
            $.ajax({
                url: links.removeMachineOptions,
                type: 'get',
                data: {
                    name: machine.name
                },
                success: function(data) {
                    machineTable.machines.$remove(machine);
                }
            });
        },
        alertMsg: function(title, info, icon, themes) {
            //display alert
            $.amaran({
                'theme': 'awesome ' + themes,
                'content': {
                    title: title,
                    message: '',
                    info: info,
                    icon: 'fa ' + icon
                },
                'position': 'bottom right',
                'outEffect': 'fadeOut'
            });
        }
    }
});


$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});