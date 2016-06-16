@extends('layouts.app')

@push('style')
<style>
    .user {
        display: flex;
        flex-wrap: wrap;
    }

    .user__image {
        border:5px solid #f3f3f3;
        border-radius:50%;
        margin-left:30px;
        margin-top:10px;
        transition: .3s;
    }

    .user__image:hover {
        border:5px solid #9DC8C8;
    }

    .user__name {
        padding-top:30px;
        padding-left:30px;
    }

    .user__position {
        color:#535353;
        font-size:15px;
    }

    .user__upload {
        color:#535353;
        font-size:15px;
        display: flex;
    }

    .alert__msg {
        position:fixed;
        top:10px;
        right:10px;
        z-index: 1;
    }
</style>
@endpush

@section('content')
    <div class="container">
        <div class="col-md-4">
            <ul class="list-group" id="sidebar">
                <a href="#profile" class="list-group-item active">Profile <i class="fa fa-angle-double-right"></i></a>
                <a href="#settings" class="list-group-item">Settings <i class="fa fa-angle-double-right"></i></a>
            </ul>
        </div>
        <form
                action="{{ route('UpdateProfile', ['id' => user()->employee_id]) }}"
                method="POST"
                role="form"
                enctype="multipart/form-data"
                {{--id="profile-form"--}}
                novalidate
        >
            {{ csrf_field() }}

            <div class="col-md-8  wow-reveal" id="profile">
                <ul class="list-group">
                    <li class="list-group-item user">
                        <img src="/uploads/avatar/{{ user()->avatar }}" 
                             width="150" 
                             height="150" 
                             alt="profile photo"
                             class="user__image"
                        >
                        <h3 class="user__name">
                            {{ $user->employee->name }}'s Profile<br/>
                            <span class="user__position">
                                {{ $user->employee->position }}
                            </span>
                            <span class="user__upload">
                                <input type="file" name="avatar" id="avatar">
                            </span>
                        </h3>
                    </li>
                    <li class="list-group-item">
                        <!-- NAME -->
                        <div class="form-group">
                            <label for="name">Name:</label>
                            <input type="text"
                                   name="name"
                                   id="name"
                                   class="form-control input-lg"
                                   value="{{ $user->employee->name }}"
                                   autocomplete="off"
                            >
                        </div>
                        <!-- EMAIL -->
                        <div class="form-group">
                            <label for="email">Email:</label>
                            <input type="text"
                                   name="email"
                                   id="email"
                                   class="form-control input-lg"
                                   value="{{ $user->employee->email }}"
                                   placeholder="Optional"
                                   autocomplete="off"
                            >
                        </div>
                        <!-- POSITION -->
                        <div class="form-group">
                            <label for="position">Position:</label>
                            <input type="text"
                                   name="position"
                                   id="position"
                                   class="form-control input-lg"
                                   value="{{ $user->employee->position }}"
                                   autocomplete="off"
                            >
                        </div>

                        <div class="form-group">
                            <label for="station">Station:</label>
                            <input type="text"
                                   name="station"
                                   id="station"
                                   class="form-control input-lg"
                                   value="{{ $user->employee->station }}"
                                   autocomplete="off"
                            >
                        </div>
                        <!-- SUBMIT -->
                        <div class="form-group">
                            <button type="submit" id="save-profile" class="btn btn-primary  btn-lg pull-right">Save Changes</button>
                            <div class="clearfix"></div>
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
                            <div class="col-md-12"><label for="question">Secret Question ( for account recovery
                                    ):</label></div>
                            <div class="col-md-7">
                                <input type="text"
                                       name="question"
                                       id="question"
                                       class="form-control input-lg"
                                       placeholder="Question"
                                       value="{{ $user->employee->question->question }}"
                                       autocomplete="off"
                                >
                                <span class="help-block">Recovery question</span>
                            </div>
                            <div class="col-md-1 text-center h4">:</div>
                            <div class="col-md-4">
                                <input type="text"
                                       name="answer"
                                       id="answer"
                                       class="form-control input-lg"
                                       placeholder="Answer"
                                       value="{{ $user->employee->question->answer }}"
                                       autocomplete="off"
                                >
                                <span class="help-block">Secret answer</span>
                            </div>
                        </div>
                        <!-- PASSWORD -->
                        <div class="form-group">
                            <label for="password">Password:</label>
                            <input type="password"
                                   name="password"
                                   id="password"
                                   class="form-control input-lg"
                                   autocomplete="off"
                            >
                            <span class="help-block">Leave blank if you're not planning to change your password</span>
                        </div>
                        <!-- PASSWORD CONFIRMATION -->
                        <div class="form-group">
                            <label for="password_confirmation">Password Confirmation:</label>
                            <input type="password"
                                   name="password_confirmation"
                                   id="password_confirmation"
                                   class="form-control input-lg"
                                   autocomplete="off"
                            >
                        </div>
                        <!-- SUBMIT -->
                        <div class="form-group">
                            <button type="submit" id="save-settings" class="btn btn-primary  btn-lg pull-right">Save Changes</button>
                            <div class="clearfix"></div>
                        </div>
                    </li>
                </ul>
            </div>
        </form>
    </div>

    <div class="alert__msg">
        @include('errors.validationErrors')
    </div>
@endsection
@push('scripts')
<script type="text/javascript">
    $(function () {
        $("div.alert__msg").delay( 10000 ).fadeOut();

        $("#sidebar a").on('click', function (event) {
            var id = $(this).attr('href'),
                    reverse = id == '#settings' ? '#profile' : '#settings';
            $('div' + id).show().addClass('reveal-top');
            $('div' + reverse).removeClass('reveal-top').hide();
            $("#sidebar a").removeClass('active');
            $('a[href=' + id + ']').addClass('active');
            event.preventDefault();
        });
// ================================ FORM VALIDATE =========================================
        $('#profile-form').validate({
            rules: {
                name: {
                    required: true
                },
                email: {
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
        var updateProfile = function (datus) {
            $.ajax({
                url: '{{ route('UpdateProfile',['id' => $currentUser->employee_id]) }}',
                type: 'GET',
                data: datus,
                success: function () {
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
        $('#save-settings').click(function (e) {
            if ($('#profile-form').valid()) {
                updateProfile($('#profile-form').serializeArray());
            }
            e.preventDefault();
        });
        $('#save-profile').click(function (e) {
            if ($('#profile-form').valid()) {
                updateProfile($('#profile-form').serializeArray());
            }
            e.preventDefault();
        });
    });
</script>
@endpush