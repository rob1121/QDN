@extends('layouts.app')

@push('style')

@endpush

@section('content')
<div class="container-fluid">
    <multiselect :selected.sync="selected" :options="options" :multiple="true"></multiselect>
</div>

@endsection

@push('scripts')
<script src="/js/vue-issue.js"></script>
@endpush