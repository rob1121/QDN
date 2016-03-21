<div class="modal" id="profile">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Profile</h4>
            </div>
            <form method="get" action ="" id="profile-form" novalidate>
                <div class="modal-body">
                    <div class="form-group col-md-4">
                        <span>Employee ID:</span>
                        <input type="text" name="user_id" v-model="profile.user_id" id="user_id" class="form-control">
                    </div>
                    <div class="clearfix"></div>
                    <div class="form-group col-md-8">
                        <span>Name:</span>
                        <input type="text" name="name" v-model="profile.name" id="name" class="form-control">
                    </div>
                    <div class="clearfix"></div>
                    <div class="form-group col-md-6">
                        <span>Access Level:</span>
                        <input type="text" name="access_level" v-model="profile.access_level" id="access_level" class="form-control">
                    </div>
                    <div class="form-group col-md-6">
                        <span>Station:</span>
                        <input type="text" name="station" v-model="profile.station" id="station" class="form-control">
                    </div>
                    <div class="form-group col-md-6">
                        <span>Department:</span>
                        <input type="text" name="department" v-model="profile.department" id="department" class="form-control">
                    </div>
                    <div class="form-group col-md-6">
                        <span>Position:</span>
                        <input type="text" name="position" v-model="profile.position" id="position" class="form-control">
                    </div>
                    <div class="form-group col-md-8">
                        <span>Email(optional):</span>
                        <input type="text" name="email" v-model="profile.email" id="email" class="form-control">
                    </div>
                    <hr>
                    <div class="form-group col-md-6">
                        <span>Password:</span>
                        <input type="password" name="password" v-model="profile.password" id="password" class="form-control">
                    </div>
                    <div class="form-group col-md-6">
                        <span>Password Confirmation:</span>
                        <input type="password" name="password_confirmation" v-model="profile.password_confirmation" id="password_confirmation" class="form-control">
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>