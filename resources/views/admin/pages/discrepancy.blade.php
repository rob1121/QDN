@extends('admin.main')
@section('content')
<div class="col-md-8 col-md-offset-2">
    <h1>Discrepancy List</h1>
    <div class="panel panel-info">
        <div class="panel-heading">
            <div class="col-md-11">
                <input type = "text"
                v-model     = "searchKey"
                debounce    = "500"
                class       = "form-control"
                placeholder = "Search Input"
                >
            </div>
            <div class="col-md-1">
                <a data-toggle="modal" href='#discrepancy_modal'>
                    <span class = "fa-stack fa-lg">
                        <i class = "fa fa-circle fa-stack-2x"></i>
                        <i class = "fa fa-plus fa-stack-1x fa-inverse"></i>
                    </span>
                </a>
            </div>
            <div class="clearfix"></div>
        </div>
        <div class="panel-body">
            <table class="table table-hover table-striped">
                <thead>
                    <tr>
                        <th><a href="#"  @click.prevent="sortBy('name')">Discrepancy</a></th>
                        <th><a href="#"  @click.prevent="sortBy('category')">Category</a></th>
                        <th><a href="#"  @click.prevent="sortBy('is_major')">Severity Level</a></th>
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
</div>
{{-- =================================== MODAL ============================================ --}}
<div class="modal fade" id="discrepancy_modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Modal title</h4>
            </div>
            <div class="modal-body">
                <form method = "get"
                    action       = ""
                    id           = "discrepancy-form"
                    novalidate
                    >
                    <div class="form-group">
                        <input id = "name"
                        name      = "name"
                        v-model      = "newDiscrepancy"
                        @keyup.enter = "updateTable"
                        class        = "input-lg form-control"
                        placeholder  = "Input Discrepancy Name"
                        required
                        >
                    </div>
                    <div class = "form-group">
                        <input id = "category"
                        name      = "category"
                        v-model   = "category"
                        list      = "category"
                        class     = "form-control input-lg"
                        >
                        <datalist id="category">
                        <option
                            v-for = "category in categories | orderBy 'category' 1"
                            value = "@{{ category.category | uppercase }}"
                            >
                            </datalist>
                        </div>
                        <div class="form-group">
                            <select id = "is_major"
                                name       = "is_major"
                                v-model    = "is_major"
                                class      = "form-control input-lg"
                                >
                                <option value = 1>Major</option>
                                <option value = 0>Minor</option>
                            </select>
                        </div>
                        <div class="form-group pull-right">
                            <button type = "button"
                            class        = "btn btn-default btn-lg"
                            @click       = "updateTable"
                            > Submit
                            <i class = "fa fa-paper-plane"></i>
                            </button>
                        </div>
                    </form>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
    </div>
    {{-- =================================== END MODAL ============================================ --}}
    <div class = "clearfix"></div>
    @stop
    @push('scripts')
    <script src = "https://cdnjs.cloudflare.com/ajax/libs/vue/1.0.17/vue.js"></script>
    <script src = "/js/vue-discrepancy.js"></script>
    @endpush