{{-- CUSTOMER OPTIONS --}}
<div class="col-sm-12">
    <div class="form-group col-sm-4">
        <span>Customer:
        </span>
        <select
            class = "form-control"
            name  = 'customer'
            id    = 'customer'
            >
            <option value=""></option>
            @foreach ($customers as $customer)
            <option value="{{ $customer->customer }}"
                @if (isset($qdn) && $qdn->customer == $customer->customer)
                selected
                @endif
                >
                {{ Str::upper($customer->customer) }}
            </option>
            @endforeach
            <option value="not yet specified">Not Yet Specified</option>
        </select>
    </div>
    <div class="form-group col-sm-5" hidden id="not-yet-specified">
        <br>
        <input
        type        = "text"
        name        = "customerField"
        id          = "customer"
        class       = "form-control"
        placeholder = "Specify Customer"
        >
    </div>
</div>
{{-- LOT INVOLVEMENT OPTIONS --}}
<div class="col-sm-12">
    <div class="form-group col-sm-12">
        <div class="checkbox" {{ $hidden == '' ? 'hidden' : '' }}>
            <label>
                <input
                type = "checkbox"
                id   = "sort"
                name = "sort"
                >
                With Lot Involved
            </label>
        </div>
    </div>
</div>
<div class="col-sm-12" id='lot-description' {{ $hidden }}>
    <!-- INPUT PACKAGE TYPE -->
    <div class="form-group col-sm-4">
        <span>Package Type:</span>
        <input
        type         = 'text'
        autocomplete = "off"
        placeholder  = "Package Type"
        name         = 'package_type'
        id           = 'package_type'
        class        = 'form-control'
        value        = "{{ isset($qdn) ? $qdn->package_type : 'N/A' }}"
        >
    </div>
    <!-- INPUT DEVICE NAME -->
    <div class="form-group col-sm-4">
        <span>Device Name:</span>
        <input
        type         = 'text'
        autocomplete = "off"
        placeholder  = "Device Name"
        name         = 'device_name'
        id           = 'device_name'
        class        = 'form-control'
        value        = "{{ isset($qdn) ? $qdn->device_name : 'N/A' }}"
        >
    </div>
    <!-- INPUT LOT ID NUMBER -->
    <div class="form-group col-sm-4">
        <span>Lot ID Number:</span>
        <input
        type         = 'text'
        autocomplete = "off"
        placeholder  = "Lot ID Number"
        name         = 'lot_id_number'
        id           = 'lot_id_number'
        class        = "form-control"
        value        = "{{ isset($qdn) ? $qdn->lot_id_number : 'N/A' }}"
        >
    </div>
    <!-- INPUT LOT QUANTITY -->
    <div class="form-group col-sm-4">
        <span>Lot Quantity:</span>
        <input
        type         = 'text'
        autocomplete = "off"
        placeholder  = "Lot Quantity"
        name         = 'lot_quantity'
        id           = 'lot_quantity'
        class        = "form-control"
        value        = "{{ isset($qdn) ? $qdn->lot_quantity : 0 }}"
        >
    </div>
</div>
<div class="col-sm-12">
    <!-- INPUT JOB ORDER NO. -->
    <div class="form-group col-sm-3">
        <span>Job Order Number:</span>
        <input
        type         = 'text'
        autocomplete = "off"
        placeholder  = "Job Order No."
        name         = 'job_order_number'
        id           = 'job_order_number'
        class        = "form-control"
        value        = "{{ isset($qdn) ? $qdn->job_order_number : '' }}"
        >
    </div>
    <!-- SELECT MACHINE -->
    <div class="form-group col-sm-3">
        <span>Machine:</span>
        <select
            class = "form-control"
            name  = 'machine'
            id    = "machine"
            >
            <option value=""></option>
            @foreach ($machines as $machine)
            <option value="{{ $machine->name }}"
                @if (isset($qdn) && $qdn->machine == $machine->name)
                selected
                @endif
            >{{ Str::upper($machine->name) }}</option>
            @endforeach
        </select>
    </div>
    <div class="form-group col-sm-3">
        <!-- SELECT STATION -->
        <span>Station:</span>
        <select
            class = "form-control"
            name  = "station"
            id    = "station"
            >
            <option value=""></option>
            @foreach ($stations as $station)
            <option value="{{ $station->station }}"
                @if (isset($qdn) && $qdn->station == $station->station)
                selected
                @endif
            >{{ Str::upper($station->station) }}</option>
            @endforeach
        </select>
    </div>
</div>
<div class="col-sm-12">
    <!-- SELECT EMPLOYEE INVOLVED -->
    <div class="form-group col-sm-6">
        <span>Issued To:</span>
        <select
            class = "form-control"
            name  = "receiver_name[]"
            id    = "receiver_name"
            multiple
            required
            >
            @if (isset($qdn))
            <?php $receiver_name = $qdn->involvePerson;?>

            @foreach ($receiver_name->pluck('receiver_name') as $name)
            <option value="{{ $name }}" selected>{{ $name }}</option>
            @endforeach
            @endif

            <?php $employeeList = collect($employees->toArray())->flatten();?>
            @foreach ( isset($qdn)
                ? $employeeList->diff($receiver_name->pluck('receiver_name','originator_name')->flatten())
                : $employeeList
                as $employee
            )
            <option value="{{ $employee }}">
                {{ Str::title($employee) }}
            </option>
            @endforeach
        </select>
    </div>
</div>
<!-- RADIO BUTTON NON COMFORMITY LEVEL -->
<div class="col-sm-12">
    <div class="form-group col-sm-12">
        <label>Non Conformity Level</label>
        <br>
        <div class="btn-group" data-toggle="buttons" id="btn-major">
            <label class="btn btn-default major
                @if (isset($qdn) && $qdn->major == 'major')
                active
                @endif
                ">
                <input
                type  = 'radio'
                id    = 'major'
                name  = 'major'
                value = 'major'
                @if (isset($qdn) && $qdn->major == 'major')
                checked
                @endif
                >
                Major
            </label>
            <label class="btn btn-default minor
                @if ((isset($qdn) && $qdn->major == 'minor') || ! isset($qdn))
                active
                @endif
                ">
                <input
                type  = 'radio'
                id    = 'major'
                name  = 'major'
                value = 'minor'
                @if ((isset($qdn) && $qdn->major == 'minor') || ! isset($qdn))
                checked
                @endif
                >
                Minor
            </label>
        </div>
    </div>
</div>
<div class="col-sm-12">
    <div class="form-group col-sm-6">
        <!-- SELECT FAILURE MODE -->
        <span>Failure Mode:</span>
        <select
            name  = "failure_mode"
            id    = "failure_mode"
            class = 'form-control'
            >
            <option value=""></option>
            @foreach ($select_failure_mode as $option)
            <option value="{{ $option }}"
                @if (isset($qdn) && $qdn->failure_mode == $option)
                selected
                @endif
            >{{ Str::title($option) }}</option>
            @endforeach
        </select>
    </div>
</div>
<div class="col-sm-12">
    <!-- SELECT FOR MINOR -->
    <div class="form-group col-sm-6" id="categories">
        <span>Discrepancy Category:</span>
        <select
            name  = "discrepancy_category"
            id    = "discrepancy_category"
            class = 'form-control'
            >
            <option value=""></option>
            <option value="SOP Violation">SOP Violation</option>
            <option value="KDTM Violation">KDTM Violation</option>
            <option value="OTHERS">OTHERS</option>
        </select>
    </div>
    <div class="form-group col-sm-3" id="quantity-field" {{ $hidden }}>
        <span>Quantity:</span>
        <input type  = "text"
        name         = "quantity"
        autocomplete = "off"
        id           = "quantity"
        class        = "form-control"
        placeholder  = "Quantity Involve"
        value        = {{ isset($qdn) ? $qdn->quantity : '' }}
        >
    </div>
    <!-- TEXTAREA OF PROBLEM DESCRIPTION -->
    <div class="form-group col-sm-12">
        <span for="problem_description">Problem Description:</span>
        <textarea  name = 'problem_description'
        id              = 'problem_description'
        placeholder     = 'Enter Detailed Information'
        rows            = '5'
        class           = 'form-control'
        >{{ isset($qdn) ? $qdn->problem_description : '' }}</textarea>
    </div>
</div>