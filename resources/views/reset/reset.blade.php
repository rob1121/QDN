@extends('layouts.app')
@section('content')
<div class="container">
    <div class="col-md-8 col-md-offset-2">
        <div class="panel panel-default">
            <div class="panel-body">
                <form action="{{ route('reset') }}" method="POST" role="form" id="reset" novalidate>
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <h1>Account Reset</h1>
                    <hr>
                    @include('errors.validationErrors')
                    <div class="form-group">
                        <input
                        type         ="text"
                        class        ="form-control input-lg"
                        autocomplete = "off"
                        id           ="employee_id"
                        name         ="employee_id"
                        placeholder  ="Employee ID"
                        value        ="{{ old('employee_id') }}"
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
$('#reset').validate({
rules: {
employee_id: {
required: true,
number: true
}
},
errorClass: "error",
errorElement: "span"
});
});
</script>
@stop