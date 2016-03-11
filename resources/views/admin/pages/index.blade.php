@extends('admin.main')
@push('styles')
<style type="text/css">
.panel-heading,
.panel-body {
border-radius: 1px;
}
</style>
@endpush
@section('content')
<div class="panel">
    <h2>
    <!-- LABEL -->
    <div class="col-md-2">Leading on</div>
    <!-- MONTH -->
    <div class="col-md-3">
        <select name="month" id="month" class="form-control input-lg">
            <option value="">All</option>
            @foreach ($months as $month)
            <option
                value="{{ Carbon::parse($month)->format('m') }}"
                @if (Carbon::parse($month)->format('m') == Carbon::now('Asia/Manila')->format('m'))
                selected
                @endif
                >
                {{ Str::title($month) }}
            </option>
            @endforeach
        </select>
    </div>
    <!-- YEAR -->
    <div class="col-md-2">
        <select name="year" id="year" class="form-control input-lg">
            @foreach ($years as $year)
            <option
                value="{{ $year }}"
                @if ($year == Carbon::now('Asia/Manila')->format('Y'))
                selected
                @endif
                >
                {{ Str::title($year) }}
            </option>
            @endforeach
        </select>
    </div>
    <div class="clearfix"></div>
    </h2>
    <div class="panel-body">
        <hr>
        @foreach ($ave as $name => $value)
        {{ $name }}
        <div class="progress">
            <div
            id            = "{{ str_slug($name,'-') }}"
            class         = " progress-bar progress-bar-success"
            role          = "progressbar"
            aria-valuenow = "{{ $value }}"
            aria-valuemin = "0"
            aria-valuemax = "100"
            style         = "width: {{ $value }}%;"
            >
                {{ $value }}%
            </div>
        </div>
        @endforeach
    </div>
</div>
@stop
@push('scripts')
    <script>
        $(function() {
            var month = $('#month').val(),
            year = $('#year').val(),
            slug = function(str) {
                var $slug = '';
                var trimmed = $.trim(str);
                $slug = trimmed.replace(/[^a-z0-9-]/gi, '-').
                replace(/-+/g, '-').
                replace(/^-|-$/g, '');
                return $slug.toLowerCase();
            },
            updateLead = function(month, year){
                $.ajax({
                        url: '{{ route('UpdateLead') }}',
                        type: 'GET',
                        data: {
                            month: month,
                            year: year
                        },
                        success: function (data) {
                                if (data == '') {
                                    var pBarInit = $('.progress div.progress-bar');
                                    pBarInit.text('0 %');
                                    pBarInit.css({width: 0 + '%'});
                                    pBarInit.attr('aria-valuenow', 0);
                                } else {
                                    $.each(data, function( index, value ) {
                                    var pBar = $('.progress div.progress-bar#' + slug(index));

                                    pBar.text(value + '%');
                                    pBar.css({width: value + '%'});
                                    pBar.attr('aria-valuenow',value);
                                    });
                                }

                        },
                        error: function() {
                            alert('error');
                        }
                    });
            };
            //GET MONTH
            $('#month').on('change', function(event) {
                event.preventDefault();
                /* Act on the event */
                var self = $(this);
                month = self.val();
                updateLead(month, year);
            });
            //GET YEAR
            $('#year').on('change', function(event) {
                event.preventDefault();
                /* Act on the event */
                var self = $(this);
                year = self.val();
                updateLead(month, year);
            });

        });
    </script>
@endpush