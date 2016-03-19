var vm = new Vue({
    el: 'body',
    data: {
        active: 'active',
        employees: employees,
        count: this.employees.length,
        pageCount: 0,
        pageCount2: 0
    },
    components: {
        selection: {
            template: '#level-selection',
            props: ['employee'],
            data: function() {
                return {
                    selectedVal: '',
                    options: ['admin', 'signatory', 'user']
                }
            },
            methods: {
                updateAccessLevel: function(name, access_level) {
                    alert(name + " is now " + access_level)
                }
            }
        }
    },
    methods: {
        countProperties: function(obj) {
            var prop;
            var propCount = 0;

            for (prop in obj) {
                propCount++;
            }
            return propCount;
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
        },
        lastPageArr: function() {
            return this.count - 1;
        },
        lastSubArr: function() {
            var lastPage = this.lastPageArr() * 5,
                subLastPage = this.countProperties(this.employees[this.lastPageArr()]) - 1;
            return lastPage + subLastPage;
        },
        nextPage: function() {
            if (this.pageCount != this.lastSubArr()) {
                this.pageCount++;
                if (this.pageCount % 5 == 0) {
                    this.pageCount2++;
                }
            }
        },
        prevPage: function() {
            if (this.pageCount != 0) {
                this.pageCount--;
                if (this.pageCount % 5 == 4 && this.pageCount2 != 0) {
                    this.pageCount2--;
                }
            }
        },
        firstPage: function() {
            this.pageCount = 0
            this.pageCount2 = 0
        },
        lastPage: function() {
            this.pageCount2 = this.lastPageArr();
            this.pageCount = this.lastSubArr();

        },
        removeEmployee: function(employee) {
            if (confirm('Are you sure you want to remove ' + employee.name + ' from the list?')) {
                vm.employees.$remove(employee)
                this.alertMsg('Successfully Removed', employee.name + 'is no longer in the list of active employee', 'fa-check', 'ok')
            }
        },
    }
})
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});