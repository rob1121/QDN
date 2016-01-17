@extends('layouts.app')
@section('external-style')
    <link rel="stylesheet" href="/vendor/css/select2.css">
    <link rel="stylesheet" href="/vendor/css/select2-bootstrap.css">
@stop
@section('style')
<style>
    select {
        visibility: hidden;
    }
    .form-control:focus,
    #s2id_receiver_name .select2-choices,
    .select2-dropdown-open .select2-choice,
    .select2-container-active .select2-default {
        box-shadow: none;
    }
</style>
@stop
@section('content')
<div class="container">
@include('errors.validationErrors')
<form
    action = "{{ route('issue_qdn') }}"
    method = "POST"
    role   = "form"
    id     = "qdn-form"
    novalidate
>
    {!! csrf_field() !!}
    {{-- CUSTOMER OPTIONS --}}
    <div class="col-xs-12">
    <h1>QDN Issuance</h1>
        <div class="form-group col-xs-3">
            <select
                class = "form-control"
                name  = 'customer'
                id    = 'customer'
            >
                <option value=""></option>
                @foreach ($customers as $customer)
                    <option value="{{ $customer->customer }}">
                    {{ Str::upper($customer->customer) }}
                    </option>
                @endforeach
                <option value="not yet specified">Not Yet Specified</option>
            </select>
        </div>
        <div class="form-group col-xs-3" hidden id="not-yet-specified">
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
    <div class="col-xs-12">
        <div class="form-group col-xs-12">
            <div class="checkbox">
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

    <div class="col-xs-12" id='lot-description' hidden>
        <!-- INPUT PACKAGE TYPE -->
        <div class="form-group col-xs-4">
            <input
                type         = 'text'
                autocomplete = "off"
                placeholder  = "Package Type"
                name         = 'package_type'
                id           = 'package_type'
                class        = 'form-control'
                value        = "N/A"
            >
        </div>
        <!-- INPUT DEVICE NAME -->
        <div class="form-group col-xs-4">
            <input
                type         = 'text'
                autocomplete = "off"
                placeholder  = "Device Name"
                name         = 'device_name'
                id           = 'device_name'
                class        = 'form-control'
                value        = "N/A"
            >
        </div>
        <!-- INPUT LOT ID NUMBER -->
        <div class="form-group col-xs-4">
            <input
            type         = 'text'
            autocomplete = "off"
            placeholder  = "Lot ID Number"
            name         = 'lot_id_number'
            id           = 'lot_id_number'
            class        = "form-control"
            value        = "N/A"
            >
        </div>
        <!-- INPUT LOT QUANTITY -->
        <div class="form-group col-xs-4">
            <input
                type         = 'text'
                autocomplete = "off"
                placeholder  = "Lot Quantity"
                name         = 'lot_quantity'
                id           = 'lot_quantity'
                class        = "form-control"
                value        = "0"
            >
        </div>
    </div>

    <div class="col-xs-12">
            <!-- INPUT JOB ORDER NO. -->
            <div class="form-group col-xs-3">
                <input
                    type         = 'text'
                    autocomplete = "off"
                    placeholder  = "Job Order No."
                    name         = 'job_order_number'
                    id           = 'job_order_number'
                    class        = "form-control"
                >
            </div>

            <!-- SELECT MACHINE -->
            <div class="form-group col-xs-3">
                <select
                    class = "form-control"
                    name  = 'machine'
                    id    = "machine"
                >
                    <option value=""></option>
                    @foreach ($machines as $machine)
                        <option value="{{ $machine->name }}">{{ Str::upper($machine->name) }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group col-xs-3">
                <!-- SELECT STATION -->
                <select
                    class = "form-control"
                    name  = "station"
                    id    = "station"
                >
                    <option value=""></option>
                @foreach ($stations as $station)
                    <option value="{{ $station->station }}">{{ Str::upper($station->station) }}</option>
                @endforeach
                </select>
            </div>
    </div>
    <div class="col-xs-12">
        <!-- SELECT EMPLOYEE INVOLVED -->
        <div class="form-group col-xs-4">
            <select
                class = "form-control"
                name  = "receiver_name[]"
                id    = "receiver_name"
                multiple
                required
            >
                @foreach ($employees as $employee)
                    <option value="{{ $employee->name }}">{{ Str::title($employee->name) }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <!-- RADIO BUTTON NON COMFORMITY LEVEL -->
    <div class="col-xs-12">
        <div class="form-group col-xs-12">
            <label>Non Conformity Level</label>
            <label id="major">
                <input
                    type  = 'radio'
                    name  = 'major'
                    id    = "major"
                    value = 'major'
                >
                Major
                <input
                    type  = 'radio'
                    name  = 'major'
                    id    = "major"
                    value = 'minor'
                    checked
                >
                Minor
            </label>
        </div>
    </div>
<div class="col-xs-12">
     <div class="form-group col-xs-4">
    <!-- SELECT FAILURE MODE -->
        <select
            name  = "failure_mode"
            id    = "failure_mode"
            class = 'form-control'
        >
        <option value=""></option>
            @foreach ($select_failure_mode as $option)
                <option value="{{ $option }}">{{ Str::title($option) }}</option>
            @endforeach
        </select>
    </div>
</div>
<div class="col-xs-12">
                    <!-- SELECT FOR MINOR -->
    <div class="form-group col-xs-4" id="categories">
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
    <div class="form-group col-xs-3" hidden id="quantity-field">
        <input
        type        = "text"
        name        = "quantity"
        id          = "quantity"
        class       = "form-control"
        placeholder = "Specify Customer"
        value       = "0"
        >
    </div>
    <!-- TEXTAREA OF PROBLEM DESCRIPTION -->
    <div class="form-group col-xs-12">
            <textarea
                name        = 'problem_description'
                placeholder = 'Enter Detailed Information'
                rows        = '5'
                class       = 'col-xs-12'
            ></textarea>
    </div>
    <!-- SUBMIT BUTTON -->
    <div class="form-group col-xs-12">
            <button
            type  = 'submit'
            name  = 'submit'
            class = 'btn btn-lg btn-primary'
            >
                <i class="fa fa-save"></i> SUBMIT
            </button>
    </div>
</div>
</form>
</div>
@stop
@section('script')
    <script src="/vendor/js/select2.min.js"></script>
    <script src="js/reportForm.js"></script>
@stop