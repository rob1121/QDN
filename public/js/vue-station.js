
var stationTable = new Vue({
    el: 'body',
    data: {
        newStation: '',
        department: '',
        stations: stations,
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
            return filter(this.stations, this.searchKey).length;
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

        addStation: function(data) {
            this.stations.push({
                station: data.station,
                department: data.department
            });
        },

        removeStation: function(station) {
            this.removeStationTable(station);
            this.alertMsg('Changes Saved!', 'Station table are now updated', 'fa-save', 'ok');
        },
        editStation: function(station) {
            name = this.newStation.trim();
            if (name) {
                this.updateStationTable(name);
            }
            this.newStation = station.station;
            this.department = station.department;
            this.removeStationTable(station);
        },
        updateTable: function() {
            var name = this.newStation.trim();
            if (name) {
                this.updateStationTable(name);
                this.newStation = '';
            }
        },
        updateStationTable: function(name) {
            $.ajax({
                url: links.updateStationOptions,
                type: 'get',
                data: {
                    station: name,
                    department: stationTable.department
                },
                success: function(data) {
                    if (data) {
                        stationTable.addStation(data);
                        stationTable.alertMsg('Changes Saved!', 'Station table are now updated', 'fa-save', 'ok');
                    } else {
                        stationTable.alertMsg('Warning!', 'Station already exist', 'fa-chain-broken', 'yellow');
                    }
                }
            });
        },
        removeStationTable: function(station) {
            $.ajax({
                url: links.removeStationOptions,
                type: 'get',
                data: {
                    station: station.station
                },
                success: function(data) {
                    stationTable.stations.$remove(station);
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