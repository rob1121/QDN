@extends('layouts.app')
@section('content')
<div class="container">
    <div class="col-md-8 col-md-offset-2">
        <div class="panel panel-default">
            <div class="panel-body">
                <form action="{{ route('question', ['id' => $user->user_id]) }}" method="POST" id="question" role="form" novalidate>
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <h1>Secret Question</h1>
                    <hr>
                    @include('errors.validationErrors')
                    <div class="form-group">
                        <p>Hello, {{ $user->name }}</p>
                        <input
                        type         = "text"
                        autocomplete = "off"
                        name         = "answer"
                        id         = "answer"
                        class        = "form-control input-lg"
                        placeholder  = "{{ $user->question->question }}"
                        value        = "{{ old('answer') }}"
                        >
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn btn-primary btn-lg">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@stop
@section('script')
<script type="text/javascript">
$(function() {
$('#question').validate({
rules: {
answer: {
required: true
}
},
errorClass: "error",
errorElement: "span"
});
});
</script>
@stop