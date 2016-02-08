@extends('layouts.app')
@section('style')
<style>
    .table {
        background-color:#fff;
    }
    #filter-group {
        padding-bottom: 12px;
    }
</style>
@stop
@section('content')
<div class="container">
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
            <label for="DiscrepancyCategory">Discrepancy Category:
                <select
                    name  = "DiscrepancyCategory"
                    id    = "DiscrepancyCategory"
                    class = "form-control input-lg"
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
            <label for="FailureMode">Failure Mode:
                <select
                    name  = "FailureMode"
                    id    = "FailureMode"
                    class = "form-control input-lg"
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
                        type        = "text"
                        class       = "form-control input-lg"
                        name        = "SearchKeyword"
                        id          = "SearchKeyword"
                        placeholder = "Search"
                    >
                    <span class="input-group-btn">
                        <button type="button" class="btn btn-default btn-lg"><i class="fa fa-search"></i></button>
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

            <th>
                <a
                    href="#"
                    data-col="problem_description"
                >
                    {{ Str::title('problem description') }} <i></i>
                </a>
            </th>

            <th>
                <a
                    href="#"
                    data-col="discrepancy_category"
                >
                    {{ Str::title('discrepancy category') }} <i></i>
                </a>
            </th>

            <th>
                <a
                    href="#"
                    data-col="failure_mode"
                >
                    {{ Str::title('failure mode') }} <i></i>
                </a>
            </th>

            <th>
                <a
                    href="#"
                    data-col="created_at"
                >
                    {{ Str::title('date / time') }} <i></i>
                </a>
            </th>

            <th>
            {{ Str::title('receiver name') }}</th>
        </tr>
    </thead>
    <tbody>
@foreach ($table as $row)
    <tr>
        <td class='info'><a href="{{ route('qdn_link', ['slug'=>$row->slug]) }}">{{ $row->control_id }}</a></td>
        <td>{{ Str::title($row->problem_description) }}</td>
        <td>{{ Str::title($row->discrepancy_category) }}</td>
        <td>{{ Str::title($row->failure_mode) }}</td>
        <td>{{ $row->created_at }}</td>
        <td>@foreach ($row->involvePerson()->select('receiver_name')->get() as $name)
            <li>{{ $name->receiver_name }}</li>
        @endforeach</td>
    </tr>
@endforeach
    </tbody>
    <tfoot>
        <tr>
            <td
                colspan = "10"
                class   = 'text-center'
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

            var column  = "control_no",
            sort        = 'ASC',
            start       = 0,
            end         = 10,
            year        = $('#year option:selected').val(),
            month       = $('#month option:selected').val(),
            loader      = $('#loading-bar'),
            column      = 'control_id',
            sort        = 'asc',
            FailureMode = $('#FailureMode option:selected').val(),
            discrepancy = $('#DiscrepancyCategory option:selected').val(),
            tbody       = $('table').find('tbody'),
            ajaxCall    = function( column, sort, start, end, year, month, discrepancy, FailureMode ) {
                $.ajax({
                    url: '/pareto-ajax',
                    type: 'get',
                    data: {
                        sort        : sort,
                        start       : start,
                        end         : end,
                        column      : column,
                        year        : year,
                        month       : month,
                        discrepancy : discrepancy,
                        FailureMode    : FailureMode
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
                    error: function(){ alert('error'); },
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
                year  = $('#year option:selected').val();
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
                ajaxCall(column, sort, start, end, year, month, discrepancy, FailureMode);
            });

// =======================================on scroll reach to bottom========================================
            $(window).scroll(function() {

                var self = $(this);

                if (self.scrollTop() + self.height() == $(document).height()) {
                    loader.show();
                    start = Number(start) + Number(end);
                    ajaxCall(column, sort, start, end, year, month, discrepancy, FailureMode);
                }
            });
//==========================================  SELECT BOX FILTERS ======================================================
    $('select').on('change',  function() {

         year        = $('#year option:selected').val();
         month       = $('#month option:selected').val();
         FailureMode = $('#FailureMode option:selected').val();
         discrepancy = $('#DiscrepancyCategory option:selected').val();
         //make ajax request
         loader.show();
         start = 0;
         tbody.empty();
        ajaxCall(column, sort, start, end, year, month, discrepancy, FailureMode);
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