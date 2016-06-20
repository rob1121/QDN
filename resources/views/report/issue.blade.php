@extends('layouts.app')

@push('style')
    <style>
        .form {
            margin: 0px 100px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            background-color: #fff;
            border-radius: 5px;
            border: 1px solid #e8e8e8;
        }

        .form>div,
        .form>h1 {
            padding: 0px 20px;
            margin-bottom: 25px;
        }

        .form__textarea {
            resize: none;
            width: 100%;
            padding: 8px;
            border-radius: 5px;
            border: 1px solid #e8e8e8;
            background: #fff;
        }

        .form__input {
            min-height: 40px;
            padding: 8px;
            border-radius: 5px;
            border: 1px solid #e8e8e8;
            background: #fff;
        }

        .multiselect__failure_mode,
        .multiselect__customer {
            min-width: 300px;

        }

        .multiselect__discrepancy_category{
            min-width: 400px;
        }

        .multiselect__employee_list {
            min-width: 600px;
        }

        .btn--major.active {
            background-color:#AF4034 !important;
        }

        .btn--minor.active {
            background-color:#fbd14b !important;
        }

        .form__lot--details>label {
            margin-right: 10px;
        }
        .form__lot--details>label>.form__input {
            width: 250px;
        }
    </style>
@endpush

@section('content')
    <div class="form wow-reveal">

        <h1 class="page-header">QDN ISSUANCE</h1>

        <div class="form__customer">
            <label>Customer:
                <multiselect
                        :selected.sync="selectedStation"
                        :options="customers"
                        placeholder="Select customer"
                        :allow-empty="false"
                        class="multiselect__customer"
                />
            </label>

            <input type="text"
                   name="other_customer"
                   id="other_customer"
                   class="form__input"
                   placeholder="customer name"
                   v-show="selectedStation == 'OTHER'"
            >
        </div>

        <div class="form__lot--checkbox">
            <label>
                <input type="checkbox" v-model="isCheck">
                Lot Involve
            </label>
        </div>

        <div class="form__lot--details" v-show="isCheck">
            <label>Lot ID Number: <br>
                <input type="text"
                       name="lot_id_number"
                       class="form__input"
                       placeholder="Input required"
                >
            </label>

            <label>Device Name: <br>
                <input type="text"
                       name="lot_id_number"
                       class="form__input"
                       placeholder="Input required"
                >
            </label>

            <label>Package Type: <br>
                <input type="text"
                       name="lot_id_number"
                       class="form__input"
                       placeholder="Input required"
                >
            </label>

            <label>Lot Quantity: <br>
                <input type="text"
                       name="lot_id_number"
                       class="form__input"
                       placeholder="Input required"
                >
            </label>

        </div>

        <div class="form__employee">
            <label>Issue Name:
                <multiselect
                        :selected.sync="selectedEmployee"
                        :options="employees"
                        :multiple="true"
                        :searchable="true"
                        placeholder="Type to search"
                        :allow-empty="false"
                        :limit="2"
                        class="multiselect__employee_list"
                />
            </label>
        </div>

        <div class="btn-group" data-toggle="buttons">

            <label class="btn btn-default btn--major">
                <input type="radio"
                       name="major"
                       autocomplete="off"
                > Major
            </label>

            <label class="btn btn-default btn--minor active">
                <input type="radio"
                       name="major"
                       autocomplete="off"
                       checked
                > Minor
            </label>

        </div>

        <div class="form__failure_mode">
            <label>Failure Mode:
                <multiselect
                        :selected.sync="selectedFailureMode"
                        :options="failureMode"
                        :allow-empty="false"
                        class="multiselect__failure_mode"
                />
            </label>
        </div>

        <div class="form__discrepancy_category">
            <label>Discrepancy Category:
                <multiselect
                        :selected.sync="selectedDiscrepancyCategory"
                        :options="discrepancies"
                        :allow-empty="false"
                        class="multiselect__discrepancy_category"
                />
            </label>
        </div>
        
        <div class="form__problem_description">
            <label>Problem Description:</label>
                <textarea class="form__textarea"
                          rows="10"
                          placeholder="Required input"
                ></textarea>
        </div>

        <div class="form__submit">
            <button class="btn btn-primary btn-lg pull-right">Submit <i class="fa fa-paper-plane"></i></button>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="/js/vue-issue.js"></script>
@endpush
