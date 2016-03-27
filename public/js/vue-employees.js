//======================= JQUERY VALIDATION ==============================
var validator = $('#profile-form').validate({
    rules: {
        user_id: {
            required: true,
            number: true
        },

        name: {
            required: true,
            minlength: 3
        },

        status: {
            required: true
        },

        access_level: {
            required: true
        },

        station: {
            required: true
        },

        position: {
            required: true,
            minlength: 2
        },

        email: {
            email: true
        },

        status: {
            required: true
        },

        password: {
            minlength: 6
        },

        password_confirmation: {
            equalTo: "#password",
            minlength: 6
        }
    },

    errorClass: "error",

    errorElement: "span"
});
//=========================== VUE ========================================
vm = new Vue({
    el: 'body',

    data: {
        isNewUser: 0,
        employeeStatusFilter: "active",
        users: employees,
        user: '',
        searchKey: '',
        reverse: 1,
        sortKey: '',
        currentPage: 0,
        itemsPerPage: 5,
        profile: {
            user_id: '',
            name: '',
            access_level: '',
            station: '',
            position: '',
            email: '',
            password: '',
            password_confirmation: '',
            status: ''

        }
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
            var status = this.employeeStatusFilter;
            var filter = Vue.filter('filterBy');
            var arr = $.grep(this.users, function(n, i) {
                return status ? n.status == status : n;
            });
            return filter(arr, this.searchKey).length;
        }
    },

    methods: {
        setPage: function(pageNumber) {
            this.currentPage = pageNumber
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

        sortBy: function(column) {
            this.sortKey = column;
            this.reverse = this.sortKey == column ? this.reverse * -1 : this.reverse = 1;
        },

        newEmployeeModal: function() {
            this.isNewUser = 1;
            validator.resetForm();
            $("#password").rules("add", "required");
            $("#password_confirmation").rules("add", "required");
            this.profile.user_id = '';
            this.profile.name = '';
            this.profile.access_level = 'user';
            this.profile.station = '';
            this.profile.position = '';
            this.profile.email = '';
            this.profile.password = '';
            this.profile.password_confirmation = '';
            this.profile.status = 'active';
            $('#profile').modal('show');
        },

        updateEmployeeModal: function(user) {
            this.user = user;
            this.isNewUser = 0;
            validator.resetForm();
            $("#password").rules("remove", "required");
            $("#password_confirmation").rules("remove", "required");
            this.profile.user_id = user.user_id;
            this.profile.name = user.name;
            this.profile.access_level = user.user.access_level;
            this.profile.station = user.station;
            this.profile.position = user.position;
            this.profile.email = user.email;
            this.profile.status = user.status;
            $('#profile').modal('show');
        },

        newEmployee: function() {
            if ($('#profile-form').valid()) {
                $.ajax({
                    url: links.newEmployee,
                    type: 'get',
                    data: vm.profile,
                    success: function(data) {
                        var info = 'User successfully registered';
                        var theme = 'ok';
                        var title = 'Success';
                        var fa = 'fa-check';
                        if (typeof data.user == 'undefined') {
                            info = '';
                            $.each(data, function(index, value) {
                                info += index + ": " + value + "\n";
                            });
                            theme = 'error';
                            title = 'Error!';
                            fa = 'fa-chain-broken';
                        } else {
                            $('#profile').modal('hide');
                            vm.users.push(data);
                        }
                        vm.alertMsg(title, info, fa, theme);
                    }
                });

            }
        },

        updateEmployee: function(user) {
            if ($('#profile-form').valid()) {
                $.ajax({
                    url: links.updateEmployee,
                    type: 'get',
                    data: vm.profile,
                    success: function(data) {
                        var info = 'Profile successfully update';
                        var theme = 'ok';
                        var title = 'Success';
                        var fa = 'fa-check';
                        if (typeof data.user == 'undefined') {
                            info = '';
                            $.each(data, function(index, value) {
                                info += index + ": " + value + "\n";
                            });
                            theme = 'error';
                            title = 'Error!';
                            fa = 'fa-chain-broken';
                        } else {
                            vm.users.$remove(user);
                            vm.users.push(data);
                            $('#profile').modal('hide');
                        }
                        vm.alertMsg(title, info, fa, theme);
                    }
                });

            }
        },

        removeEmployee: function(user) {
            if (confirm('Are you sure you want to remove ' + user.name + ' from the list?')) {
                $.ajax({
                    url: links.removeEmployee,
                    type: 'get',
                    data: {
                        id: user.id
                    },
                    success: function(data) {
                        vm.users.$remove(user);
                        var info = user.name + 'is no longer in the list of active employee';
                        vm.alertMsg('Successfully Removed', info, 'fa-check', 'ok');
                    }
                });
            }
        }
    },

    filters: {
        paginate: function(list) {
            var index = this.currentPage * parseInt(this.itemsPerPage)
            return list.slice(index, index + parseInt(this.itemsPerPage))
        },
        status: function(users) {
            if (this.employeeStatusFilter == '') return users;

            return users.filter(function(user) {
                return user.status == this.employeeStatusFilter;
            }.bind(this));
        }
    }
});

//============================== AJAX =====================================
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});