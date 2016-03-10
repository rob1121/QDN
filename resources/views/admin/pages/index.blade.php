@extends('admin.main')
@section('content')
@foreach ($qdn as $data)
    <li>{{ $data->failure_mode }}</li>
@endforeach
@stop