@extends('layouts.app')
@push('style')
<link rel="stylesheet" type="text/css" href="/css/vue-report.css">
@endpush
@section('content')

        @include('report.section_header')
        @include('report.section_disposition')
        @include('report.section_cod')

@endsection
@push('scripts')
<script src="/js/vue-report.js"></script>
@endpush