<!-- SECOND PANEL -->
<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title">DISPOSITION:</h3>
    </div>
    <div class="panel-body">
        <div class="container">
            @foreach ($disposition_check as $disposition)
            <div class="col-lg-2 col-md-2 col-sm-3 col-xs-6 pull-left">
                <input
                type  = 'radio'
                name  = 'disposition'
                class = 'disposition'
                value = '{{ $disposition }}'
                disabled
                {{
                $qdn->disposition == $disposition
                ? 'checked'
                : ''
                }}
                >
                {{ Str::upper($disposition) }}
            </div>
            @endforeach
        </div>
    </div>
</div>
<!-- THIRD PANEL -->
<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title">CAUSE OF DEFECTS/ FAILURE:</h3>
    </div>
    <div class="panel-body">
        <div class="col-xs-12">
            <div class="container" id="cause-of-defect-section">
                @foreach ($cod_check as $cod)
                <div class="col-lg-2 col-md-2 col-sm-3 col-xs-6 pull-left">
                    <input
                    type  = 'radio'
                    name  = 'cause_of_defect'
                    value = '{{ $cod }}'
                    {{ $disabled }}
                    {{
                    $qdn->CauseOfDefect->cause_of_defect == $cod
                    ? 'checked'
                    : ''
                    }}
                    >
                    {{ Str::upper($cod) }}
                </div>
                @endforeach
            </div>
            <div class="row" {{ $hidden }}>
                <!-- CAUSE OF DEFECT OE -->
                <div class='form-group text-left col-sm-3'><label for="">CAUSE OF DEFECTS OE:</label>
                <br>
                <span class="btn btn-default" id="upload-btn">
                    <i class="fa fa-plus"></i>
                    <span>Select File..</span>
                </span>
                <div class="upload-file-container">
                    <input
                    type = 'file'
                    name = 'upload_cod'
                    id   = "upload_cod"
                    >
                </div>
            </div>
        </div>
        <textarea
        rows        = '5'
        id          = 'what'
        name        = 'cause_of_defect_description'
        placeholder = 'Input Detailed Cause of Defect'
        {{ $disabled }}
        >{{ $qdn->CauseOfDefect->cause_of_defect_description }}</textarea>
        <br>
        <span id="count" {{ $hidden }}>Characters left: 250</span>
    </div>
</div>
</div>
<!-- FOURTH PANEL -->
<div class="panel panel-default">
<div class="panel-heading">
    <h3 class="panel-title">CONTAINMENT ACTION/S:</h3>
</div>
<div class="panel-body">
    <!-- CONTAINEMENT ACTION WHAT -->
    <div class="col-sm-9">
        <textarea
        rows        = "10"
        id          = "what"
        name        = "containment_action_textarea"
        placeholder = 'Input Containment Action'
        {{ $disabled }}
        >{{ $qdn->containmentAction->what }}</textarea>
        <br>
        <span id="count" {{ $hidden }}>Characters left: 250</span>
    </div>
    <div class="col-sm-3">
        <br>
        <div class="form-group">
            <strong> WHO:</strong>
            <select
                name  = "containment_action_who"
                id    = "containment_action_who"
                class = "form-control"
                {{ $disabled }}
                >
                <option value="{{ $qdn->containmentAction->who }}" selected>
                    {{ $qdn->containmentAction->who }}
                </option>
                @foreach ($names as $name)
                @if ($currentUser->employee->name != $name->name)
                <option value="{{ $name->name }}">{{ $name->name }}</option>
                @endif
                @endforeach
            </select>
        </div>
        <!-- CONTAINEMENT ACTION WHEN -->
        <div class="form-group">
            <strong> WHEN:</strong>
            <input
            class       = "form-control"
            type        = "text"
            name        = "containment_action_taken"
            id          = "containment-action-taken"
            value       = "{{ Carbon::parse($qdn->containmentAction->updated_at)->format('m/d/Y') }}"
            placeholder = "Input date"
            readonly
            {{ $disabled }}
            >
        </div>
        <!-- CONTAINEMENT ACTION OE -->
        <div class="form-group" {{ $hidden }}>
            <strong>CONTAINMENT ACTION OE:</strong>
            <br>
            <span class="btn btn-default" id="upload-btn">
                <i class="fa fa-plus"></i>
                <span>Select File..</span>
            </span>
            <div class="upload-file-container">
                <input
                type = 'file'
                name = 'upload_containment_action'
                id   = "upload_containment_action"
                >
            </div>
        </div>
    </div>
</div>
<!-- FIFTH PANEL -->
<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title">CORRECTIVE ACTION/S:</h3>
    </div>
    <div class="panel-body">
        <!-- CORRECTIVE ACTION/S WHAT -->
        <div class="col-sm-9">
            <textarea
            rows        = "10"
            id          = "what"
            name        = "corrective_action_textarea"
            placeholder = 'Input Corrective Action'
            {{ $disabled }}
            >{{ $qdn->correctiveAction->what }}</textarea>
            <br>
            <span id="count" {{ $hidden }}>Characters left: 250</span>
        </div>
        <div class="col-sm-3">
            <br>
            <!-- CORRECTIVE ACTION/S WHO -->
            <div class="form-group">
                <strong> WHO:</strong>
                <select
                    name  = "corrective_action_who"
                    id    = "corrective_action_who"
                    class = "form-control"
                    {{ $disabled }}
                    >
                    <option value="{{ $qdn->correctiveAction->who }}" selected>
                        {{ $qdn->correctiveAction->who }}
                    </option>
                    @foreach ($names as $name)
                    @if ($currentUser->employee->name != $name->name)
                    <option value="{{ $name->name }}">{{ $name->name }}</option>
                    @endif
                    @endforeach
                </select>
            </div>
            <!-- CORRECTIVE ACTION/S WHEN -->
            <div class="form-group">
                <strong> WHEN:</strong>
                <input
                class       = "form-control"
                type        = "text"
                name        = "corrective_action_taken"
                id          = "corrective-action-taken"
                value       = "{{ Carbon::parse($qdn->correctiveAction->updated_at)->format('m/d/Y') }}"
                placeholder = "Input date"
                readonly
                {{ $disabled }}
                >
            </div>
            <!-- CORRECTIVE ACTION/S OE -->
            <div class="form-group" {{ $hidden }}>
                <strong>CORRECTIVE ACTION OE:</strong>
                <br>
                <span class="btn btn-default" id="upload-btn">
                    <i class="fa fa-plus"></i>
                    <span>Select File..</span>
                </span>
                <div class="upload-file-container">
                    <input
                    type = 'file'
                    name = 'upload_corrective_action'
                    id   = "upload_corrective_action"
                    >
                </div>
            </div>
        </div>
    </div>
</div>
<!-- SIXTH PANEL -->
<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title">PREVENTIVE ACTION/S:</h3>
    </div>
    <div class="panel-body">
        <!-- PREVENTIVE ACTION/S WHAT -->
        <div class="col-sm-9">
            <textarea
            rows        = "10"
            id          = "what"
            name        = "preventive_action_textarea"
            placeholder = 'Input Preventive Action'
            {{ $disabled }}
            >{{ $qdn->preventiveAction->what }}</textarea>
            <br>
            <span id="count" {{ $hidden }}>Characters left: 250</span>
        </div>
        <div class="col-sm-3">
            <br>
            <!-- PREVENTIVE ACTION/S WHO -->
            <div class="form-group">
                <strong> WHO:</strong>
                <select
                    name  = "preventive_action_who"
                    id    = "preventive_action_who"
                    class = "form-control"
                    {{ $disabled }}
                    >
                    <option value="{{ $qdn->preventiveAction->who }}" selected>
                        {{ $qdn->preventiveAction->who }}
                    </option>
                    @foreach ($names as $name)
                    @if ($currentUser->employee->name != $name->name)
                    <option value="{{ $name->name }}">{{ $name->name }}</option>
                    @endif
                    @endforeach
                </select>
            </div>
            <!-- PREVENTIVE ACTION/S WHEN -->
            <div class="form-group">
                <strong> WHEN:</strong>
                <input
                class       = "form-control"
                type        = "text"
                name        = "preventive_action_taken"
                id          = "preventive-action-taken"
                value       = "{{ Carbon::parse($qdn->preventiveAction->updated_at)->format('m/d/Y') }}"
                placeholder = "Input date"
                readonly
                {{ $disabled }}
                >
            </div>
            <!-- PREVENTIVE ACTION/S OE -->
            <div class="form-group" {{ $hidden }}>
                <strong>PREVENTIVE ACTION OE:</strong>
                <br>
                <span class="btn btn-default" id="upload-btn">
                    <i class="fa fa-plus"></i>
                    <span>Select File..</span>
                </span>
                <div class="upload-file-container">
                    <input
                    type = 'file'
                    name = 'upload_preventive_action'
                    id   = "upload_preventive_action"
                    >
                </div>
            </div>
        </div>
    </div>
</div>