@extends('admin.main')
@push('styles')
<style type="text/css">
table {
background-color: #fff;
}
#data-link {
margin-bottom: 8px;
}
span.error {
    color: red;
}
</style>
@endpush
@section('content')
<div class="container-fluid">
    <h2>Employee List @{{ count }}</h2>
    <hr>
    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="col-md-10">
                <div class="col-md-5 col-md-offset-1 pull-right">
                    <input
                    type        = "text"
                    class       = "form-control"
                    placeholder = "Search Input"
                    v-model="searchKey"
                    >
                </div>

                <div class="col-md-3 pull-left">
                    <div class="col-md-4 text-right">
                        <h5>Display:</h5>
                    </div>
                    <div class="col-md-8 text-left">
                        <select  v-model="itemsPerPage" class="form-control">
                            <option value='5' >5</option>
                            <option value='10' >10</option>
                            <option value='25' >25</option>
                            <option value='50' >50</option>
                            <option value='100' >100</option>
                        </select>
                    </div>
                </div>

                <div class="col-md-3 pull-left">
                    <div class="col-md-3 text-right">
                        <h5>Show:</h5>
                    </div>
                    <div class="col-md-9 text-left">
                        <select  v-model="employeeStatusFilter" class="form-control">
                            <option value='' >All</option>
                            <option value='active'>Active</option>
                            <option value='deactivated'>Deactivated</option>
                        </select>
                    </div>
                </div>

            </div>
            <div class="col-md-2 text-right">
                <a href="#"  id="new-employee" @click.prevent="newEmployeeModal">
                    <span class="fa-stack fa-lg">
                        <i class="fa fa-circle fa-stack-2x"></i>
                        <i class="fa fa-plus fa-stack-1x fa-inverse"></i>
                    </span>
                </a>
            </div>
            <div class="clearfix"></div>
        </div>
        <div class="panel-body">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th><a href="#" @click.prevent="sortBy('user_id')">#</a></th>
                        <th><a href="#" @click.prevent="sortBy('name')">Name</a></th>
                        <th><a href="#" @click.prevent="sortBy('station')">Station</a></th>
                        <th><a href="#" @click.prevent="sortBy('email')">Email</a></th>
                        <th><a href="#" @click.prevent="sortBy('user.access_level')">Access Level</a></th>
                        <th><a href="#" @click.prevent="sortBy('user.status')">Status</a></th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="user in users | orderBy sortKey reverse | filterBy searchKey | paginate | status">
                        <td>@{{ user.user_id | uppercase }}</td>
                        <td>@{{ user.name | uppercase }}</td>
                        <td>@{{ user.station | uppercase }}</td>
                        <td>@{{ user.email }}</td>
                        <td>@{{ user.user.access_level | uppercase }}</td>
                        <td>@{{ user.user.status | uppercase }}</td>
                        <td>
                            <a href="#" @click.prevent="updateEmployeeModal(user)" class="text-primary">
                                <span class="fa-stack fa-lg">
                                    <i class="fa fa-circle fa-stack-2x"></i>
                                    <i class="fa fa-edit fa-stack-1x fa-inverse"></i>
                                </span>
                            </a>
                            <a  href="#"  @click.prevent="removeEmployee(user)" class="text-danger">
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
    <ul class="pagination">
        <li  :class="{'active': currentPage == pageNumber}" v-for="pageNumber in totalPages">
            <a href="#" @click.prevent="setPage(pageNumber)">@{{ pageNumber+1 }}</a>
        </li>
    </ul>
</div>
@include('admin.pages.employees_modal')
@stop
@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/vue/1.0.17/vue.js"></script>
<script src="/js/vue-employees.js"></script>
@endpush