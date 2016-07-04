@extends('layouts.app')
@push('style')
<link rel="stylesheet" type="text/css" href="/css/vue-report.css">
@endpush
@section('content')

        @include('report.section_header')
        @include('report.section_disposition')
        @include('report.section_cod')
        @include('report.section_actions')
        @include('report.section_approval')

@endsection
@push('scripts')
<script src="/js/vue-report.js"></script>
@endpush