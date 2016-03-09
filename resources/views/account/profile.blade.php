@extends('layouts.app')
@section('style')
<style type="text/css">
.list-group-item i.fa {
float: right;
}
.list-group-item:first-child,
.list-group-item:last-child {
border-radius: 0px;
}
.list-group-item.active,
.list-group-item.active:hover,
.list-group-item.active:active,
.list-group-item.active:focus {
background-color:#f5f5f5;
color: #222;
border-color:#ddd;
font-weight:bold;
}
.form-control,
.form-control:hover,
.form-control:active,
.form-control.active,
.form-control:focus {
box-shadow: none;
}
</style>
@endsection
@section('content')
<div class="container">
    <div class="col-md-4">
        <ul class="list-group" id="sidebar" >
            <a href="#profile" class="list-group-item active">Profile <i class="fa fa-angle-double-right"></i></a>
            <a href="#settings" class="list-group-item">Settings <i class="fa fa-angle-double-right"></i></a>
        </ul>
    </div>
    <form
        action = "{{ route('issue_qdn') }}"
        method = "POST"
        role   = "form"
        id     = "profile-form"
        novalidate
        >
        <div class="col-md-8" id="profile">
            <ul class="list-group">
                <li class="list-group-item">
                    <h1>Profile</h1>
                </li>
                <li class="list-group-item">
                    <!-- NAME -->
                    <div class="form-group">
                        <label for="name">Name:</label>
                        <input type="text" name="name" id="name" class="form-control input-lg" value="{{ $user->employee->name }}">
                    </div>
                    <!-- EMAIL -->
                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="text" name="email" id="email" class="form-control input-lg" value="{{ $user->employee->email }}">
                    </div>
                    <!-- POSITION -->
                    <div class="form-group">
                        <label for="position">Position:</label>
                        <input type="text" name="position" id="position" class="form-control input-lg" value="{{ $user->employee->position }}">
                    </div>
                    <!-- DEPARTMENT -->
                    <div class="form-group">
                        <label for="department">Department:</label>
                        <input type="text" name="department" id="department" class="form-control input-lg" value="{{ $user->employee->department }}">
                    </div>
                    <!-- STATION -->
                    <div class="form-group">
                        <label for="station">Station:</label>
                        <input type="text" name="station" id="station" class="form-control input-lg" value="{{ $user->employee->station }}">
                    </div>
                    <!-- SUBMIT -->
                    <div class="form-group">
                        <button type="submit" id="save-profile" class="btn btn-info  btn-lg">Save Changes</button>
                    </div>
                </li>
            </ul>
        </div>
        <div class="col-md-8" id="settings" hidden>
            <ul class="list-group">
                <li class="list-group-item">
                    <h1>Settings</h1>
                </li>
                <li class="list-group-item">
                    <!-- QUESTION -->
                    <div class="form-group row">
                        <div class="col-md-12"><label for="question">Secret Question ( for account recovery ):</label></div>
                        <div class="col-md-7">
                            <input
                            type        = "text"
                            name        = "question"
                            id          = "question"
                            class       = "form-control input-lg"
                            placeholder = "Question"
                            value       = "{{ $user->employee->question->question }}"
                            >
                        </div>
                        <div class="col-md-1 text-center h4">-</div>
                        <div class="col-md-4">
                            <input
                            type        = "text"
                            name        = "answer"
                            id          = "answer"
                            class       = "form-control input-lg"
                            placeholder = "Answer"
                            value       = "{{ $user->employee->question->answer }}"
                            >
                        </div>
                    </div>
                    <!-- PASSWORD -->
                    <div class="form-group">
                        <label for="password">Password:</label>
                        <input type="password" name="password" id="password" class="form-control input-lg">
                    </div>
                    <!-- PASSWORD CONFIRMATION -->
                    <div class="form-group">
                        <label for="password_confirmation">Password Confirmation:</label>
                        <input type="password" name="password_confirmation" id="password_confirmation" class="form-control input-lg">
                    </div>
                    <!-- SUBMIT -->
                    <div class="form-group">
                        <button type="submit"  id="save-settings" class="btn btn-info  btn-lg">Save Changes</button>
                    </div>
                </li>
            </ul>
        </div>
    </form>
</div>
@endsection
@push('scripts')
<script type="text/javascript">
$(function() {
$("#sidebar a").on('click', function(event) {
var id = $(this).attr('href'),
reverse = id == '#settings' ? '#profile' : '#settings';
$('div' + id).show();
$('div' + reverse).hide();
$("#sidebar a").removeClass('active');
$('a[href=' + id + ']').addClass('active');
event.preventDefault();
});
// ================================ FORM VALIDATE =========================================
$('#profile-form').validate({
ignore: '',
rules: {
name: {
required: true
},
email: {
required: true,
email: true
},
department: {
required: true
},
station: {
required: true
},
position: {
required: true
},
question: {
    required: true
},
answer: {
    required: true
},
password: {
    minlength: 6
},
password_confirmation: {
    equalTo: "#password",
    minlength: 6
}
},
errorClass: "error",
errorElement: "span"
});
var updateProfile = function(datus) {
    $.ajax({
        url: '{{ route('UpdateProfile',['id' => $currentUser->employee_id]) }}',
        type: 'GET',
        data: datus,
        success: function (data) {
            $.amaran({
                    'theme': 'awesome ok',
                    'content': {
                        title: 'Success!',
                        message: '',
                        info: 'Profile are now Updated!',
                        icon: 'fa fa-save'
                    },
                    'position': 'bottom right',
                    'outEffect': 'fadeOut'
                });
        }
    });
};
$('#save-settings').click(function(e){
    updateProfile($('#profile-form').serializeArray());
    e.preventDefault();
});
$('#save-profile').click(function(e){
    updateProfile($('#profile-form').serializeArray());
    e.preventDefault();
});
});
</script>
@endpush