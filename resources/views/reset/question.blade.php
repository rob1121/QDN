@extends('layouts.app')
@section('content')
<div class="container">
    @include('errors.validationErrors');
    <form action="{{ route('question', ['id' => $user->user_id]) }}" method="POST" role="form">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <legend>Secret Question</legend>

        <div class="form-group">
            <p>Hello, {{ $user->name }}</p>
            <input
                type         = "text"
                autocomplete = "off"
                name         = "answer"
                class        = "form-control"
                placeholder  = "{{ $user->question->question }}"
                value        = "{{ old('answer') }}"
            >
        </div>

        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>
@stop