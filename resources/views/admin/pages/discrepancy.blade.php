@extends('admin.main')
@section('content')
<div class="col-md-8 col-md-offset-2">
    <h1>Discrepancy List</h1>
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
                        <th><a href="#"  @click.prevent="sortBy('name')">Discrepancy</a></th>
                        <th><a href="#"  @click.prevent="sortBy('category')">Category</a></th>
                        <th><a href="#"  @click.prevent="sortBy('is_major')">Major(Binary)</a></th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for = "discrepancy in discrepancies | orderBy sortKey reverse | filterBy searchKey | paginate">
                        <td>@{{ discrepancy.name | uppercase }}</td>
                        <td>@{{ discrepancy.category | uppercase }}</td>
                        <td>@{{ discrepancy.is_major }}</td>
                        <td class = "col-md-3">
                            <a  @click = "editDiscrepancy(discrepancy)" class="text-primary">
                                <span class = "fa-stack fa-lg">
                                    <i class = "fa fa-circle fa-stack-2x"></i>
                                    <i class = "fa fa-edit fa-stack-1x fa-inverse"></i>
                                </span>
                            </a>
                            <a  @click = "removeDiscrepancy(discrepancy)" class="text-danger">
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
    <div class="form-group">
        <input type  = "text"
        v-model      = "newDiscrepancy"
        @keyup.enter = "updateTable"
        class        = "input-lg form-control"
        placeholder  = "Input Discrepancy Name"
        >
    </div>
    <div class="form-group">
        <input v-model="category" list="category" class="form-control input-lg">
        <datalist id="category">
        <option v-for="category in categories" value="@{{ category.category | uppercase }}">
            </datalist>
        </div>
        <div class="form-group pull-right">
            <button type = "button"
            class        = "btn btn-default btn-lg"
            @click       = "updateTable"
            > Submit
            <i class = "fa fa-paper-plane"></i>
            </button>
        </div>
    </div>
    <div class = "clearfix"></div>
    @stop
    @push('scripts')
    <script src = "https://cdnjs.cloudflare.com/ajax/libs/vue/1.0.17/vue.js"></script>
    <script src = "/js/vue-discrepancy.js"></script>
    @endpush