
@extends('admin.main')
@push('styles')
<style type="text/css">
table {
background-color: #fff;
}
#data-link {
margin-bottom: 8px;
}
</style>
@endpush
@section('content')
<div class="container-fluid">
    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="col-md-3">
                <h4>Employee List</h4>
            </div>
            <div class="col-md-7 text-right">
                <label>
                    <input
                    type        = "text"
                    name        = "search"
                    id          = "search"
                    class       = "form-control"
                    placeholder = "Search Input">
                </label>
            </div>
            <div class="col-md-2 text-right">
                <a  data-toggle="modal" href='#profile'>
                    <span class="fa-stack fa-lg">
                        <i class="fa fa-circle fa-stack-2x"></i>
                        <i class="fa fa-plus fa-stack-1x fa-inverse"></i>
                    </span>
                </a>
                <a @click="order = order *  -1">
                    <span class="fa-stack fa-lg">
                        <i class="fa fa-circle fa-stack-2x"></i>
                        <i class="fa fa-refresh fa-stack-1x fa-inverse"></i>
                    </span>
                </a>
            </div>
            <div class="clearfix"></div>
        </div>
        <div class="panel-body">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th class="col-md-1">#</th>
                        <th>Name</th>
                        <th>Station</th>
                        <th>Email</th>
                        <th class="col-md-2">Access Level</th>
                        <th class="col-md-2">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="employee in employees[presentArrayCount2][presentArrayCount]">
                        <td>@{{ employee.user_id }}</td>
                        <td>@{{ employee.name }}</td>
                        <td>@{{ employee.station | uppercase }}</td>
                        <td>@{{ employee.email }}</td>
                        <td><selection :employee="employee"></selection></td>
                        <td>
                            <a  @click="editEmployee(employee)" class="text-primary">
                                <span class="fa-stack fa-lg">
                                    <i class="fa fa-circle fa-stack-2x"></i>
                                    <i class="fa fa-edit fa-stack-1x fa-inverse"></i>
                                </span>
                            </a>
                            <a  @click="removeEmployee(employee)" class="text-danger">
                                <span class="fa-stack fa-lg">
                                    <i class="fa fa-circle fa-stack-2x"></i>
                                    <i class="fa fa-trash fa-stack-1x fa-inverse"></i>
                                </span>
                            </a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

    </div>
<div class="container-fluid text-center">
        <ul class="pagination">
            <li><a href="#" @click.prevent="presentArrayCount = 0">&laquo;</a></li>
            <li><a href="#" @click.prevent="presentArrayCount2 -= 1">&laquo;</a></li>
            <li v-for="(index, item) in paginationArrays[presentArrayCount2]"><a href="#" @click.prevent="presentArrayCount = index">@{{ index }}</a></li>
            <li><a href="#" @click.prevent="presentArrayCount2 += 1">&raquo;</a></li>
            <li><a href="#" @click.prevent="presentArrayCount = count-1">&raquo;</a></li>
        </ul>

    <ul class="list-inline">
        <li>Total: @{{ count }}</li>
        <li>/</li>
        <li>@{{presentArrayCount+1 + " of " + count }}</li>
    </ul>
</div>
</div>
{{-- @include('admin.pages.employees_modal') --}}
<template id = "level-selection">
<select name = "access_level"
    id           = "access_level"
    class        = "form-control"
    v-model      = "selectedVal"
    @change      = "updateAccessLevel(employee.name,selectedVal)"
    >
    <option
        v-for = "option in options"
        selected = "@{{ selectedVal = employee.user.access_level }}"
    > @{{ option }}</option>
</select>
</template>
@stop
@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/vue/1.0.17/vue.js"></script>
<script>
var vm = new Vue({
el: 'body',
data: {
employees: employees,
count: this.employees.length,
paginationArrays: employees,
presentArrayCount: 0,
presentArrayCount2: 0,
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
getTotal: function() {
this.count = this.name.length
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
removeEmployee: function(employee) {
if (confirm('Are you sure you want to remove ' + employee.name + ' from the list?')) {
vm.employees.$remove(employee)
this.alertMsg('Successfully Removed', employee.name + 'is no longer in the list of active employee', 'fa-check', 'ok')
}
},
nextPage: function(){},
prevPage: function(){},
firstPage: function(){},
lastPage: function(){},
}
})
$.ajaxSetup({
headers: {
'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
}
});
</script>
@endpush