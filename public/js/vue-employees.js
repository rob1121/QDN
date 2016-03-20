//======================= JQUERY VALIDATION ==============================
var validator = $('#profile-form').validate({
    rules: {
        user_id: {
            required: true
        },
        name: {
            required: true
        },
        access_level: {
            required: true
        },
        station: {
            required: true
        },
        department: {
            required: true
        },
        position: {
            required: true
        },
        email: {
            email: true
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
        count: 0,
        employeeStatusFilter: 'active',
        users: employees,
        searchKey: '',
        reverse: 1,
        sortKey: '',
        currentPage: 0,
        itemsPerPage: 5,
        user_id: '',
        name: '',
        access_level: '',
        station: '',
        department: '',
        position: '',
        email: '',
        password: '',
        password_confirmation: '',
    },
    computed: {
        totalPages: function() {
            return Math.ceil(this.users.length / parseInt(this.itemsPerPage))
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
        newEmployeeModal: function() {
            validator.resetForm();
            $("#password").rules("add", "required");
            $("#password_confirmation").rules("add", "required");
            this.user_id = '';
            this.name = '';
            this.access_level = '';
            this.station = '';
            this.department = '';
            this.position = '';
            this.email = '';
            this.password = '';
            this.password_confirmation = '';
            $('#profile').modal('show');
        },
        updateEmployeeModal: function(user) {
            validator.resetForm();
            $("#password").rules("remove", "required");
            $("#password_confirmation").rules("remove", "required");
            this.user_id = user.user_id;
            this.name = user.name;
            this.access_level = user.user.access_level;
            this.station = user.station;
            this.department = user.department;
            this.position = user.position;
            this.email = user.email;
            $('#profile').modal('show');
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
                        vm.alertMsg('Successfully Removed', user.name + 'is no longer in the list of active employee', 'fa-check', 'ok');
                    }
                });
            }
        },
        sortBy: function(column) {
            this.sortKey = column;
            this.reverse = this.sortKey == column ? this.reverse * -1 : this.reverse = 1;
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
                return user.user.status == this.employeeStatusFilter;
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