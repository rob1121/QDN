
var customerTable = new Vue({
    el: 'body',
    data: {
        newCustomer: '',
        customers: customers,
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
            return filter(this.customers, this.searchKey).length;
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

        addCustomer: function(customer) {
            this.customers.push({
                customer: customer
            });
        },
        removeCustomer: function(customer) {
            this.removeCustomerTable(customer);
            this.alertMsg('Changes Saved!', 'Customer table are now updated', 'fa-save', 'ok');
        },
        editCustomer: function(name) {
            customer = this.newCustomer.trim();
            if (customer) {
                this.updateCustomerTable(customer);
            }
            this.newCustomer = name.customer;
            this.removeCustomerTable(name);
        },
        updateTable: function() {
            var customer = this.newCustomer.trim();
            if (customer) {
                this.updateCustomerTable(customer);
                this.newCustomer = '';
            }
        },
        updateCustomerTable: function(customer) {
            $.ajax({
                url: links.updateCustomerOptions,
                type: 'get',
                data: {
                    customer: customer
                },
                success: function(data) {
                    if (data == 'unique') {
                        customerTable.addCustomer(customer);
                        customerTable.alertMsg('Changes Saved!', 'Customer table are now updated', 'fa-save', 'ok');
                    } else {
                        customerTable.alertMsg('Warning!', 'Customer already exist', 'fa-chain-broken', 'yellow');
                    }
                }
            });
        },
        removeCustomerTable: function(customer) {
            $.ajax({
                url: links.removeCustomerOptions,
                type: 'get',
                data: {
                    customer: customer.customer
                },
                success: function(data) {
                    customerTable.customers.$remove(customer);
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