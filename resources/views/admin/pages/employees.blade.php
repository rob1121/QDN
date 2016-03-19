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
                        <th ><a href="#" @click.prevent="sortArr('name',true)">Name</a></th>
                        <th ><a href="#" @click.prevent="sortArr('station',true)">Station</a></th>
                        <th ><a href="#" @click.prevent="sortArr('email',true)">Email</a></th>
                        <th  class="col-md-2"><a href="#" @click.prevent="sortArr('user.access_level',true)">Access Level</a></th>
                        <th class="col-md-2">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="employee in employees[pageCount2][pageCount]">
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
            <li><a href="#" @click.prevent="firstPage"><i class="fa fa-angle-double-left"></i></a></li>
            <li><a href="#" @click.prevent="prevPage"><i class="fa fa-angle-left"></i></a></li>
            <li v-for="(index, item) in employees[pageCount2]"  v-bind:class="[ pageCount == index? 'active' : '']">
                <a href="#" @click.prevent="pageCount = index">@{{ parseInt(index)+1 }}</a>
            </li>
            <li><a href="#" @click.prevent="nextPage"><i class="fa fa-angle-right"></i></a></li>
            <li><a href="#" @click.prevent="lastPage"><i class="fa fa-angle-double-right"></i></a></li>
        </ul>
        <ul class="list-inline">
            <li>Total: @{{ count }}</li>
            <li>/</li>
            <li>@{{(parseInt(pageCount)+1) + " of " + (parseInt(lastSubArr())+1) }}</li>
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
<script src="/js/vue-employees.js"></script>
@endpush