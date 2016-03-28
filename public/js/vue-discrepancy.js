var validator = $('#discrepancy-form').validate({
    rules: {
        name: {
            required: true,
            minlength: 3
        },

        category: {
            required: true,
            minlength: 3
        },

        is_major: {
            required: true,
            number: true
        },

    },

    errorClass: "error",

    errorElement: "span"
});

//================================= VUE INSTANCE =========================
var discrepancyTable = new Vue({
    el: 'body',
    data: {
        newDiscrepancy: '',
        category: '',
        is_major: 0,
        discrepancies: discrepancies,
        categories: categories,
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
            return filter(this.discrepancies, this.searchKey).length;
        }
    },
    filters: {
        paginate: function(list) {
            var index = this.currentPage * parseInt(this.itemsPerPage)
            return list.slice(index, index + parseInt(this.itemsPerPage))
        }
    },
    methods: {
        sortBy: function(column) {
            this.sortKey = column;
            this.reverse = this.sortKey == column ? this.reverse * -1 : this.reverse = 1;
        },

        setPage: function(pageNumber) {
            this.currentPage = pageNumber
        },

        addDiscrepancy: function(data) {
            this.discrepancies.push({
                name: data.name,
                category: data.category,
                is_major: data.is_major
            });
        },

        removeDiscrepancy: function(discrepancy) {
            this.removeDiscrepancyTable(discrepancy);
            this.alertMsg('Changes Saved!', 'Discrepancy table are now updated', 'fa-save', 'ok');
        },
        editDiscrepancy: function(discrepancy) {
            name = this.newDiscrepancy.trim();
            if (name) {
                this.updateDiscrepancyTable(name);
            }
            this.newDiscrepancy = discrepancy.name;
            this.category = discrepancy.category;
            this.is_major = discrepancy.is_major;
            this.removeDiscrepancyTable(discrepancy);

            $('#discrepancy_modal').modal('show');
        },

        updateTable: function() {
            if ($('#discrepancy-form').valid()) {
                var name = this.newDiscrepancy.trim();
                if (name) {
                    this.updateDiscrepancyTable(name);
                    this.newDiscrepancy = '';
                    $('#discrepancy_modal').modal('hide');
                }

            }
        },

        updateDiscrepancyTable: function(name) {
            $.ajax({
                url: links.updateDiscrepancy,
                type: 'get',
                data: {
                    name: name,
                    category: discrepancyTable.category,
                    is_major: discrepancyTable.is_major,
                },
                success: function(data) {
                    if (data) {
                        discrepancyTable.addDiscrepancy(data);
                        discrepancyTable.alertMsg('Changes Saved!', 'Discrepancy table are now updated', 'fa-save', 'ok');
                    } else {
                        discrepancyTable.alertMsg('Warning!', 'Discrepancy already exist', 'fa-chain-broken', 'yellow');
                    }
                }
            });
        },
        removeDiscrepancyTable: function(discrepancy) {
            $.ajax({
                url: links.removeDiscrepancy,
                type: 'get',
                data: {
                    name: discrepancy.name
                },
                success: function(data) {
                    discrepancyTable.discrepancies.$remove(discrepancy);
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