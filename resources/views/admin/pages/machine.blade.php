@extends('admin.main')
@section('content')
<div class="col-md-6 col-md-offset-3">
    <h1>Machine List</h1>
    <div class="panel panel-info">
        <div class="panel-heading">
            <input type = "text"
            v-model     = "searchKey"
            debounce    = "500"
            class       = "form-control input-lg"
            placeholder = "Search Input"
            >
        </div>
        <div class="panel-body">
            <table class="table table-hover table-striped">
                <thead>
                    <tr>
                        <th><a href="#"  @click.prevent="sortBy('name')">Machine</a></th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for = "machine in machines | orderBy sortKey reverse | filterBy searchKey | paginate">
                        <td>@{{ machine.name | uppercase }}</td>
                        <td class = "col-md-3">
                            <a  @click = "editMachine(machine)" class="text-primary">
                                <span class = "fa-stack fa-lg">
                                    <i class = "fa fa-circle fa-stack-2x"></i>
                                    <i class = "fa fa-edit fa-stack-1x fa-inverse"></i>
                                </span>
                            </a>
                            <a  @click = "removeMachine(machine)" class="text-danger">
                                <span class = "fa-stack fa-lg">
                                    <i class = "fa fa-circle fa-stack-2x"></i>
                                    <i class = "fa fa-trash fa-stack-1x fa-inverse"></i>
                                </span>
                            </a>
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="container-fluid text-center">
                <ul class="pagination text-center" v-show="totalPages > 1">
                    <li>
                        <a href="#" @click.prevent="setPage(0)">
                            <i class="fa fa-angle-double-left"></i>
                        </a>
                    </li>
                    <li>
                        <a href="#" @click.prevent="currentPage = currentPage ? currentPage-1 : 0">
                            <i class="fa fa-angle-left"></i>
                        </a>
                    </li>
                    <li
                        :class = "{'active': currentPage == pageNumber}"
                        v-for  = "pageNumber in totalPages"
                        v-show = "pageNumber >= firstPoint && pageNumber <= lastPoint"
                        >
                        <a href="#" @click.prevent="setPage(pageNumber)">@{{ pageNumber+1 }}</a>
                    </li>
                    <li>
                        <a href="#" @click.prevent="currentPage = currentPage != (totalPages-1) ? currentPage+1 : currentPage">
                            <i class="fa fa-angle-right"></i>
                        </a>
                    </li>
                    <li>
                        <a href="#" @click.prevent="setPage(totalPages-1)">
                            <i class="fa fa-angle-double-right"></i>
                        </a>
                    </li>
                </ul>
                <p :class = "[resultCount ? 'text-success':'text-warning']" v-show = "searchKey != ''">
                    "<strong>@{{ searchKey }}</strong>" results <strong>@{{ resultCount }}</strong> found
                </p>
            </div>
        </div>
    </div>
    <div class = "input-group">
        <input
        v-model      = "newMachine"
        @keyup.enter = "updateTable"
        class        = "input-lg form-control"
        placeholder  = "Input Machine Name"
        >
        <span class  = "input-group-btn">
            <button type = "button"
            class        = "btn btn-default btn-lg"
            @click       = "updateTable"
            >
            <i class = "fa fa-paper-plane"></i>
            </button>
        </span>
    </div>
</div>
<div class = "clearfix"></div>
@stop
@push('scripts')
<script src = "https://cdnjs.cloudflare.com/ajax/libs/vue/1.0.17/vue.js"></script>
<script src = "/js/vue-machine.js"></script>
@endpush