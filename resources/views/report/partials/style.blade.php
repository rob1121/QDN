@section('external-style')
    <link rel = "stylesheet" href="/vendor/css/select2.css">
    <link rel = "stylesheet" href="/vendor/css/select2-bootstrap.css">
    <link rel = "stylesheet" href="/vendor/css/bootstrap-datepicker.css">
@stop
@section('style')
<style>

.col-xs-5 p {
border-bottom: 1px solid grey;
}

.panel {
margin-top:0px;
margin-bottom:-1px;
border-radius: 0px;
}

.bold {
font-weight: bold;
text-align:right;
}
panel-body {
padding:0px;
}

#what {
width: 100%;
padding:15px;
resize: none;
}

.panel .panel-heading {
border-radius: 0px;
background-color:#800000;
color:#fff;
}

button[type="submit"] {
margin: 25px 0px 50px 0px;
}

.form-control[disabled],
.form-control[readonly],
fieldset[disabled] .form-control {
    background-color: #fff;
}
.error,
.select2-choice,
.select2-choice:focus,
.error .select2-choices,
input.form-control:focus,
.error .select2-choice.select2-default {
    box-shadow: none;
}

input[type="file"]{
    display: none;
}

.edit {
    float:right;
}

.btn-print {
    margin-bottom: 12px;
}

[disabled],
.select2-container-disabled,
.select2-container.select2-container-disabled .select2-choice,
.select2-container.select2-container-disabled .select2-choices {
	background-color: #fff;
}

[hidden] {
	display:none;
}
body .container {
    font-size:13px;
    padding:0px;
}
</style>
@stop
