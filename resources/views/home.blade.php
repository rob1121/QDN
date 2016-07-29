@extends('layouts.app')
@section('content')
{{-- STATUS =========================================================--}}
<div class="container">
    @include('errors.validationErrors')
    <!-- <legend class="h1">Status: </legend> -->
</div>

<div class="container">
    <qdn-collapse :list.sync="qdn"></qdn-collapse>
</div>
@include('home.modals')
@endsection
@section('script')
<script src="{{ $server }}/js/vue-home.js"></script>
@stop