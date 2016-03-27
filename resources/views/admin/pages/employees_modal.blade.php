<div class="modal"
    id="profile">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type = "button"
                class        = "close"
                data-dismiss = "modal"
                aria-hidden  = "true"
                >&times;
                </button>
                <h4 class="modal-title">Profile</h4>
            </div>
            <form method = "get"
            action       = ""
            id           = "profile-form"
                novalidate
                >
                <div class="modal-body">
                    <div class="form-group col-md-4">
                        <span>Employee ID:</span>
                        <input type  = "text"
                        autocomplete = "off"
                        name         = "user_id"
                        v-model      = "profile.user_id"
                        id           = "user_id"
                        class        = "form-control"
                        v-show       = "isNewUser"
                        >
                        <p v-else >@{{ profile.user_id }}</p>
                    </div>
                    <div class="clearfix"></div>
                    <div class="form-group col-md-8">
                        <span>Name:</span>
                        <input type  = "text"
                        autocomplete = "off"
                        name         = "name"
                        v-model      = "profile.name"
                        id           = "name"
                        class        = "form-control"
                        >
                    </div>
                    <div class="form-group col-md-4" v-show="! isNewUser">
                        <span>Status:</span>
                        <select name = "status"
                        id           = "status"
                        class        = "form-control"
                        v-model      = "profile.status"
                            >
                            <option value = "active">Active</option>
                            <option value = "resigned">Resigned</option>
                        </select>
                    </div>
                    <div class="clearfix"></div>
                    <div class="form-group col-md-4">
                        <span>Access Level:</span>
                        <select name = "access_level"
                        id           = "access_level"
                        class        = "form-control"
                        v-model      = "profile.access_level"
                            >
                            <option value = "user">User</option>
                            <option value = "signatory">Signatory</option>
                            <option value = "admin">Admin</option>
                        </select>
                    </div>
                    <div class="form-group col-md-4">
                        <span>Station:</span>
                        <select name = "station"
                        id           = "station"
                        class        = "form-control"
                        v-model      = "profile.station"
                            >
                            @foreach ($stations as $station)
                            <option value="{{ $station->station }}">{{ $station->station }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-md-4">
                        <span>Position:</span>
                        <input type  = "text"
                        autocomplete = "off"
                        name         = "position"
                        v-model      = "profile.position"
                        id           = "position"
                        class        = "form-control"
                        >
                    </div>
                    <div class = "clearfix"></div>
                    <div class = "form-group col-md-12">
                        <span>Email(optional):</span>
                        <input type  = "text"
                        autocomplete = "off"
                        name         = "email"
                        v-model      = "profile.email"
                        id           = "email"
                        class        = "form-control"
                        >
                    </div>
                    <hr>
                    <div class="form-group col-md-6" v-show="isNewUser">
                        <span>Password:</span>
                        <input type  = "password"
                        autocomplete = "off"
                        name         = "password"
                        v-model      = "profile.password"
                        id           = "password"
                        class        = "form-control"
                        >
                    </div>
                    <div class="form-group col-md-6" v-show="isNewUser">
                        <span>Password Confirmation:</span>
                        <input type  = "password"
                        autocomplete = "off"
                        name         = "password_confirmation"
                        v-model      = "profile.password_confirmation"
                        id           = "password_confirmation"
                        class        = "form-control"
                        >
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="modal-footer">
                    <button type = "button"
                    class        = "btn btn-default"
                    data-dismiss = "modal"
                    >
                    Close
                    </button>
                    <button type   = "submit"
                    class          = "btn btn-primary"
                    @click.prevent = "newEmployee"
                    v-show = "isNewUser"
                    >
                    Submit
                    </button>

                    <button type   = "submit"
                    class          = "btn btn-primary"
                    @click.prevent = "updateEmployee(user)"
                    v-else
                    >
                    Save changes
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>