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
  margin-top: 0px;
  margin-bottom: -1px;
  border-radius: 0px;
}

.bold {
  font-weight: bold;
  text-align: right;
}

panel-body {
  padding: 0px;
}

#what {
  width: 100%;
  padding: 15px;
  resize: none;
}

.panel .panel-heading {
  border-radius: 0px;
  background-color: #800000;
  color: #fff;
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

input[type="file"] {
  display: none;
}

.edit {
  float: right;
  padding-left: 10px;
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
  display: none;
}

body .container {
  font-size: 13px;
  padding: 0px;
}

select {
  visibility: hidden;
}

.form-control:focus,
#s2id_receiver_name .select2-choices,
.select2-dropdown-open .select2-choice,
.select2-container-active .select2-default {
  box-shadow: none;
}

.valid.active,
.valid.active:hover,
.major.active,
.major.active:hover {
  color: #fff;
  background-color: #c9302c;
  border-color: #ac2925;
}

#dispositions .active,
#dispositions .active:hover,
.minor.active,
.minor.active:hover {
  color: #fff;
  background-color: #ec971f;
  border-color: #d58512;
}

/*#dispositions .active,
#dispositions .active:hover {
  color: #fff;
  background-color: #3071a9;
  border-color: #285e8e;
}*/

.invalid.active,
.invalid.active:hover {
  color: #fff;
  background-color: #449d44;
  border-color: #398439;
}

.amaran.awesome.ok .bold {
  text-align: left;
}

.control_id {
  color:Red;
  font-weight:bold;
}

div.modal-dialog {
width : 50% ;
}

#qdn-form {
  margin-top:-20px;
}
</style>
@yield('substyle')
@stop
