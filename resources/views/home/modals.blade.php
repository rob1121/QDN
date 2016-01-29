<div class="modal fade" id="modalQdnMetrics">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button
                    type         = "button"
                    class        = "close"
                    data-dismiss = "modal"
                    aria-hidden  = "true"
                >&times;</button>
                <h4 class="modal-title">
                    QDN January - December {{ Carbon::now('Asia/Manila')->year }}
                </h4>
            </div>
            <div class="modal-body">
            <div class="row">
            <div id="qdnMetrics"></div>
            <table id="tblQdnMetrics" class="table table-bordered">

                <thead>
                    @for ($i = 0; $i < 12; $i++)
                        <?php $month = $i+1 ?>
                        <th class="text-center" style="background-color:#800; color:#fff">
                        {!!
                            Carbon::parse('2000-' . $month . '-01')
                            ->format("M")
                        !!}
                        </th>
                    @endfor
                </thead>

                <tr>
                    @for ($i = 0; $i < 12; $i++)
                        <td class="text-center">0</td>
                    @endfor
                </tr>

            </table>
            </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="pod">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button
                    type         = "button"
                    class        = "close"
                    data-dismiss = "modal"
                    aria-hidden  = "true"
                >&times;</button>
                <h4 class="modal-title">
                    Pareto of Discrepancy
                </h4>
            </div>
            <div class="modal-body">
            <div class="row">
            <div id="podGraph"></div>
            <table id="tblQdnMetrics" class="table table-bordered">
                <thead>
                    @foreach (['Legend','Discrepancy','Count'] as $title)
                        <th
                            class = "text-center"
                            style = "background-color:#800; color:#fff"
                        >{{ $title }}
                        </th>
                    @endforeach
                </thead>
               <tbody id="pareto-data"></tbody>
            </table>
            </div>
            </div>
        </div>
    </div>
</div>



{{-- ===================================================================== --}}

@foreach ($charts as $chart)
@if ($chart['id'] != 'pod' || $chart['id'] != 'modalQdnMetrics')
    <div class="modal fade" id="{{ $chart['id'] }}">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button
                    type         = "button"
                    class        = "close"
                    data-dismiss = "modal"
                    aria-hidden  = "true"
                >&times;</button>
                <h4 class="modal-title">
                    {{ Str::Title($chart['title']) }}
                </h4>
            </div>
            <div class="modal-body">
            <div class="row">
           <div id="{{ $chart['graph'] }}"></div>
            </div>
            </div>
        </div>
    </div>
</div>
@endif
@endforeach