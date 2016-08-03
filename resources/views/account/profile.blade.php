@extends('layouts.app')

@push('style')
<link rel="stylesheet" type="text/css" href="{{ $server }}/css/profile.css">
@endpush

@section('content')
    <div class="container" id="profile" v-cloak>

        <div class="container-fluid">@include('errors.validationErrors')</div>
        <div class="col-md-4">
            <ul class="list-group" id="sidebar">
                <a href="#" @click.prevent="isFirstPanelActive = true"
                   :class="['list-group-item', {'active' : isFirstPanelActive}]">Profile <i
                            class="fa fa-angle-double-right"></i></a>
                <a href="#" @click.prevent="isFirstPanelActive = false"
                   :class="['list-group-item', {'active' : ! isFirstPanelActive}]">Settings <i
                            class="fa fa-angle-double-right"></i></a>
            </ul>
        </div>

        <form action="{{ $route_UpdateProfile }}" method="POST" role="form" enctype="multipart/form-data"
              id="profile-form">
            {{ csrf_field() }}
            <div class="col-md-8" id="profile" v-show="isFirstPanelActive">
                <ul class="list-group main__content">
                    <li class="list-group-item user">
                        <img src="/uploads/avatar/{{ $user->avatar }}" width="150" height="150" alt="profile photo"
                             class="user__image">

                        <h3 class="user__name">
                            {{ $user->employee->name }}'s Profile<br/>
                            <span class="user__position">{{ $user->employee->position }}</span>
                            <span class="user__upload"><input type="file" name="avatar" id="avatar"></span>
                        </h3>
                    </li>
                    <li class="list-group-item">
                        <div class="form-group">
                            <label for="name">Name:</label>
                            <input type="text" name="name" id="name" class="form-control"
                                   value="{{ $user->employee->name }}" autocomplete="off">
                        </div>

                        <div class="form-group">
                            <label for="email">Email:</label>
                            <input type="text" name="email" id="email" class="form-control"
                                   value="{{ $user->employee->email }}" placeholder="Optional" autocomplete="off">
                        </div>

                        <div class="form-group">
                            <div class="col-md-8 position">
                                <label for="position">Position:</label>
                                <input type="text" name="position" id="position" class="form-control"
                                       value="{{ $user->employee->position }}" autocomplete="off">
                            </div>

                            <div class="col-md-4 station">
                                <label for="station">Station:</label>
                                <input type="text" name="station" id="station" class="form-control"
                                       value="{{ $user->employee->station }}" autocomplete="off">
                            </div>
                        </div>

                        <div class="form-group submit">
                            <button type="submit" class="btn btn-primary  btn-lg pull-right">Save Changes</button>
                        </div>
                    </li>
                </ul>
            </div>


            <div class="col-md-8" id="settings" v-else>
                <ul class="list-group main__content">
                    <li class="list-group-item"><h1>Settings</h1></li>
                    <li class="list-group-item">
                        <div class="form-group row">
                            <div class="col-md-12">
                                <label for="question">Secret Question ( for account recovery):</label>
                            </div>

                            <div class="col-md-7">
                                <input type="text" name="question" id="question" class="form-control"
                                       placeholder="Question" value="{{ $user->employee->question->question }}"
                                       autocomplete="off">
                                <span class="help-block">Recovery question</span>
                            </div>

                            <div class="col-md-1 text-center h4">:</div>

                            <div class="col-md-4">
                                <input type="text" name="answer" id="answer" class="form-control" placeholder="Answer"
                                       value="{{ $user->employee->question->answer }}" autocomplete="off">
                                <span class="help-block">Secret answer</span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="password">Password:</label>
                            <input type="password" name="password" id="password" class="form-control"
                                   autocomplete="off">
                            <span class="help-block">Leave blank if you're not planning to change your password</span>
                        </div>

                        <div class="form-group">
                            <label for="password_confirmation">Password Confirmation:</label>
                            <input type="password" name="password_confirmation" class="form-control" autocomplete="off">
                        </div>

                        <div class="form-group submit">
                            <button type="submit" class="btn btn-primary  btn-lg pull-right">Save Changes</button>
                        </div>
                    </li>
                </ul>
            </div>
        </form>
    </div>
@endsection
@push('scripts')
<script src="{{ $server }}/js/vue-profile.js"></script>
@endpush