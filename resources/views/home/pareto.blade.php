@extends('layouts.app')
@section('style')
    <style>
        .table {
            background-color: #fff;
        }

        #filter-group {
            padding-bottom: 12px;
        }

        li {
            list-style-type: none;
        }

        .table > tbody > tr > td {
            vertical-align: middle;
        }

        .export-link {
            margin-bottom: 25px;
        }
    </style>
@stop
@section('content')
    <div class="col-md-12 wow-reveal">
            <a href="{{ route('admin.pareto.excel') }}"
               class="btn btn-lg btn-primary export-link"
            >
                Export to excel
            </a>
        <div class="row" id="filter-group">
            <div class="col-xs-2">
                {{-- filter by month --}}
                <div class="form-group">
                    <label for="month">Month:
                        <select name="month" id="month" class="form-control input-lg">
                            <option value="">All</option>
                            @foreach ($months as $month)
                                <option
                                        value="{{ Carbon::parse($month)->format('m') }}"
                                        @if ($month == Request::input('month'))
                                        selected
                                        @endif
                                >
                                    {{ Str::title($month) }}
                                </option>
                            @endforeach
                        </select>
                    </label>
                </div>
            </div>
            {{-- filter by year --}}
            <div class="col-xs-2">
                <div class="form-group">
                    <label for="year">Year:
                        <select name="year" id="year" class="form-control input-lg">
                            @foreach ($years as $year)
                                <option
                                        value="{{ $year }}"
                                        @if ($year == $SelectedYear)
                                        selected
                                        @endif
                                >
                                    {{ Str::title($year) }}
                                </option>
                            @endforeach
                        </select>
                    </label>
                </div>
            </div>
            {{-- filter by discrepancy category --}}
            <div class="col-xs-3">
                <div class="form-group">
                    <label for="DiscrepancyCategory">Category:
                        <select
                                name="DiscrepancyCategory"
                                id="DiscrepancyCategory"
                                class="form-control input-lg"
                        >
                            <option value="">All</option>
                            @foreach ($DiscrepancyCategories as $row)
                                <option
                                        value="{{ $row->discrepancy_category }}"
                                        @if ($row->discrepancy_category == Request::input('discrepancy'))
                                        selected
                                        @endif
                                >
                                    {{ Str::title($row->discrepancy_category) }}
                                </option>
                            @endforeach
                        </select>
                    </label>
                </div>
            </div>
            {{-- filter by failure mode --}}
            <div class="col-xs-2">
                <div class="form-group">
                    <label for="FailureMode">Source:
                        <select
                                name="FailureMode"
                                id="FailureMode"
                                class="form-control input-lg"
                        >
                            <option value="">All</option>
                            @foreach ($FailureModes as $row)
                                <option
                                        value="{{ $row->failure_mode }}"
                                        @if ($row->failure_mode == Request::input('discrepancy'))
                                        selected
                                        @endif
                                >
                                    {{ Str::title($row->failure_mode) }}
                                </option>
                            @endforeach
                        </select>
                    </label>
                </div>
            </div>
            {{-- filter by keyword --}}
            <div class="col-xs-2">
                <div class="form-group">
                    <label for="SearchKeyword">Search Keyword:
                        <div class="input-group">
                            <input
                                    type="text"
                                    class="form-control input-lg"
                                    name="SearchKeyword"
                                    id="SearchKeyword"
                                    placeholder="Search"
                            >
                        <span class="input-group-btn">
                            <button type="button" class="btn btn-default btn-lg" id="SearchButton"><i
                                        class="fa fa-search"></i></button>
                        </span>
                        </div>
                    </label>
                </div>
            </div>
        </div>
        {{-- ======================================== Table ============================== --}}
        <table class="table table-hover">
            <thead>
            <tr>
                <th class='info'>
                    <a
                            href="#"
                            data-col="control_id"
                    >
                        # <i class="fa fa-sort-down"></i>
                    </a>
                </th>
                <th class="col-md-5">
                    <a
                            href="#"
                            data-col="problem_description"
                    >
                        {{ Str::title('description') }} <i></i>
                    </a>
                </th>
                <th>
                    <a
                            href="#"
                            data-col="discrepancy_category"
                    >
                        {{ Str::title('category') }} <i></i>
                    </a>
                </th>
                <th>
                    <a
                            href="#"
                            data-col="failure_mode"
                    >
                        {{ Str::title('Source') }} <i></i>
                    </a>
                </th>
                <th>
                    <a
                            href="#"
                            data-col="created_at"
                    >
                        {{ Str::title('timestamps') }} <i></i>
                    </a>
                </th>
                <th>
                    {{ Str::title('recipient') }}</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($table as $row)
                <tr>
                    <td class='info'><a href="{{ route('link_for_pe_verification', ['slug'=>$row->slug]) }}">{{ $row->control_id }}</a>
                    </td>
                    <td class="justify">{{ $row->problem_description }}</td>
                    <td>{{ $row->discrepancy_category }}</td>
                    <td>{{ $row->failure_mode }}</td>
                    <td>{{ Carbon::parse($row->created_at)->diffForHumans() }}</td>
                    <td>@foreach ($row->involvePerson as $name)
                            <li>{{ $name->receiver_name }}</li>
                        @endforeach</td>
                </tr>
            @endforeach
            </tbody>
            <tfoot>
            <tr>
                <td
                        colspan="10"
                        class='text-center'
                >
                    <i class="fa fa-spinner fa-pulse fa-3x" id="loading-bar"></i>
                </td>
            </tr>
            </tfoot>
        </table>
    </div>
@stop
@section('script')
    <script>
        $(function () {
            var column = "control_no",
                    sort = 'ASC',
                    start = 0,
                    end = 10,
                    year = $('#year option:selected').val(),
                    month = $('#month option:selected').val(),
                    loader = $('#loading-bar'),
                    column = 'control_id',
                    sort = 'asc',
                    FailureMode = $('#FailureMode option:selected').val(),
                    discrepancy = $('#DiscrepancyCategory option:selected').val(),
                    tbody = $('table').find('tbody'),
                    ajaxCall = function (column, sort, start, end, year, month, discrepancy, FailureMode, text) {
                        $.ajax({
                            url: '/pareto-ajax',
                            type: 'get',
                            data: {
                                sort: sort,
                                start: start,
                                end: end,
                                column: column,
                                year: year,
                                month: month,
                                discrepancy: discrepancy,
                                FailureMode: FailureMode,
                                text: text
                            },
                            success: function (data) {
                                if (data != '') {
                                    loader.hide();
                                    tbody.append(data);
                                } else {
                                    loader.hide();
                                    tbody.children('tr').children('td[colspan="6"]').remove();
                                    tbody.append('<tr><td colspan="6" class="text-center warning">No more data to show</td></tr>');
                                }
                            },
                            error: function () {
                                alert('error');
                            },
                        });
                    };
            loader.hide();
// =======================================================sorting columns===========================================
            $('th a').click(function (e) {
                e.preventDefault();
                var self = $(this),
                        header = self.parent().addClass('info').siblings().removeClass('info').children();
                loader.show();
//setup new value
                start = 0;
                option:
                        month = $('#month option:selected').val();
                if (column !== self.data('col')) {
                    sort = 'ASC';
                    column = self.data('col');
                }
                sort = (sort == 'ASC') ? 'DESC' : 'ASC';
                header.children('i').removeClass('fa fa-sort-down fa-sort-up');
                self.children('i').removeClass('fa fa-sort-down fa-sort-up');
                (sort == 'ASC')
                        ? self.children('i').addClass('fa fa-sort-down')
                        : self.children('i').addClass('fa fa-sort-up');
//make ajax request
                tbody.empty();
                ajaxCall(column, sort, start, end, year, month, discrepancy, FailureMode, '');
            });
// =======================================on scroll reach to bottom========================================
            $(window).scroll(function () {
                var self = $(this);
                if (self.scrollTop() + self.height() == $(document).height()) {
                    loader.show();
                    start = Number(start) + Number(end);
                    ajaxCall(column, sort, start, end, year, month, discrepancy, FailureMode, '');
                }
            });
//==========================================  SELECT BOX FILTERS ======================================================
            $('select').on('change', function () {
                year = $('#year option:selected').val();
                month = $('#month option:selected').val();
                FailureMode = $('#FailureMode option:selected').val();
                discrepancy = $('#DiscrepancyCategory option:selected').val();
//make ajax request
                loader.show();
                start = 0;
                tbody.empty();
                ajaxCall(column, sort, start, end, year, month, discrepancy, FailureMode, '');
            });
            $('#SearchKeyword').keyup(function () {
                if (event.keyCode == 13) {
                    var text = $(this).val();
                    year = $('#year option:selected').val();
                    $('#month').val('');
                    $('#FailureMode').val('');
                    $('#DiscrepancyCategory').val('');
//make ajax request
                    loader.show();
                    start = 0;
                    tbody.empty();
                    ajaxCall(column, sort, start, end, year, month, discrepancy, FailureMode, text);
                }
            });
            $('#SearchButton').click(function (e) {
                e.preventDefault();
                var text = $('#SearchKeyword').val();
                year = $('#year option:selected').val();
                $('#month option:selected').val('');
                $('#FailureMode').val('');
                $('#DiscrepancyCategory').val('');
//make ajax request
                loader.show();
                start = 0;
                tbody.empty();
                ajaxCall(column, sort, start, end, year, month, discrepancy, FailureMode, text);
            });
//==========================================AJAX SETUP======================================================
            $.ajaxSetup({
                headers: {
                    'X-CSRF-Token': $('meta[name=_token]').attr('content')
                }
            });
        });
    </script>
@stop