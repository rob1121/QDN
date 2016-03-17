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
    <h1>Employee List</h1>
    <div class="col-md-12 text-right" id="data-link">
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
    <table class="table table-hover">
        <thead>
            <tr>
                <th class="col-md-1">#</th>
                <th>Name</th>
                <th>Station</th>
                <th>Position</th>
                <th class="col-md-2">Access Level</th>
                <th class="col-md-2">Actions</th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="employee in employees  | orderBy 'name' order">
                <td>@{{ $index+1 }}</td>
                <td>@{{ employee.name }}</td>
                <td>@{{ employee.station | uppercase }}</td>
                <td>@{{ employee.email }}</td>
                <td><selection level=@{{ employee.user.access_level }}></selection></td>
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
<div class="clearfix"></div>
@include('admin.pages.employees_modal')
<template id="level-selection">
    <select name="access_level" id="access_level" class="form-control" v-model="selected">
        <option v-for="option in options"> @{{  level }}</option>
    </select>
</template>
@stop
@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/vue/1.0.17/vue.js"></script>
<script>
window.onbeforeunload = function(){
$('body').hide();
}
window.onunload  = function(){
return 'unloaded';
}
var employeeTable = new Vue({
el: 'body',
data: {
order: 1,
name: 'Robinson L. Legaspi',
employees: employees
},
components: {
    selection:  {
        template: '#level-selection',
        props:['level'],
        data: function(){
            return {
                selected: 'user',
                options:['admin' ,'signatory' ,'user']
            }
        }
    }
},
methods: {
updateAccessLevel: function(name, access_level) {
alert(name + "is now" + access_level);
}
}
})
$.ajaxSetup({
headers: {
'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
}
});
</script>
@endpush