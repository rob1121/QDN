@extends('admin.main')
@push('styles')
<style type="text/css">
table {
background-color: #fff;
}
#tbl-container {
overflow: auto;
height:300px;
margin-bottom:32px;
}
#tbl-container::-webkit-scrollbar {
width: 5px;
}
#tbl-container::-webkit-scrollbar-track {
-webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.3);
border-radius: 10px;
}
#tbl-container::-webkit-scrollbar-thumb {
border-radius: 10px;
-webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.5);
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
    <div id="tbl-container">
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
                    <td>@{{ $index }}</td>
                    <td>@{{ employee.name }}</td>
                    <td>@{{ employee.station | uppercase }}</td>
                    <td>@{{ employee.email }}</td>
                    <td>@{{ employee.user.access_level | uppercase }}</td>
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
<div class="clearfix"></div>
@include('admin.pages.employees_modal')
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
}
})
$.ajaxSetup({
headers: {
'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
}
});
</script>
@endpush