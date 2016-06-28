@extends('layouts.app')

@section('content')
    <div id="app">
        <h1>Corrective action</h1>
        <div v-for="action in correctiveAction">
            <input v-model="action.what" placeholder="what">
            <input v-model="action.who" placeholder="who">
            <input v-model="action.when"  placeholder="when">
            <button @click="removeAction(action)">
            <i class="fa fa-close" style="color:firebrick"></i>
            </button>
        </div>
        <button @click="addAction">
        New Find
        </button>
    </div>
@endsection
@push('scripts')
<script src="/js/vue-report.js"></script>
@endpush