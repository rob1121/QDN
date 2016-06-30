@extends('layouts.app')
@section('content')
    <div id="app">
        <form-section
                title="Containment Action"
                :actions.sync="containmentAction"
                :names="cnNames"
        >
        </form-section>

        <form-section
                title="Corrective Action"
                :actions.sync="correctiveAction"
                :names="caNames"
        >
        </form-section>

        <form-section
                title="Preventive Action"
                :actions.sync="preventiveAction"
                :names="paNames"
        >
        </form-section>
    </div>
@endsection
@push('scripts')
<script src="/js/vue-report.js"></script>
@endpush