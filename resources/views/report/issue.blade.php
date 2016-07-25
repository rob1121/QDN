@extends('layouts.app')

@push('style')
<link rel="stylesheet" href="/css/vue-issue.css">
@endpush

@section('content')
    <form action="{{ route('issue_qdn') }}" method="POST">
        {!! csrf_field() !!}
        <div class="form wow-reveal">
            <h1>QDN ISSUANCE</h1>

            <qdn-alert :list="error"></qdn-alert>

            <div class="form__employee">
                <label>Issued To:
                    <multiselect
                            :selected.sync="input.receiver_name"
                            :options="category.employees"
                            :multiple="true"
                            :searchable="true"
                            placeholder="Type to search"
                            :allow-empty="false"
                            :limit="2"
                            class="multiselect__employee_list"
                    />
                </label>
            </div>

            <div class="form__field">
                <div class="form__customer">
                    <label>Customer:
                        <multiselect
                                :selected.sync="input.customer"
                                :options="category.customers"
                                placeholder="Select customer"
                                :allow-empty="false"
                                class="multiselect__customer"
                        />

                    </label>

                    <qdn-input name="other_customer"
                               label="Other customer"
                               :input.sync="input.other_customer"
                               :show="input.customer == 'OTHER'"
                    >
                    </qdn-input>

                </div>
            </div>

           <div class="select-group">
               <div class="form__station">
                   <label>Station:
                       <multiselect
                               :selected.sync="input.station"
                               :options="category.stations"
                               placeholder="Select station"
                               :allow-empty="false"
                               class="multiselect__station"
                       />

                   </label>
               </div>

               <div class="form__machine">
                   <label>Machine:
                       <multiselect
                               :selected.sync="input.machine"
                               :options="category.machines"
                               placeholder="Select machine"
                               :allow-empty="false"
                               class="multiselect__machine"
                       />

                   </label>
               </div>
           </div>

            <div class="form__lot--checkbox">
                <label>
                    <input type="checkbox" v-model="isCheck">
                    Lot Involve
                </label>
            </div>

            <div class="form__lot--details" v-show="isCheck">

                <qdn-input name="lot_id_number"
                           label="Lot ID number"
                           :input.sync="input.lot_id_number"
                >
                </qdn-input>

                <qdn-input name="device_name"
                           label="Device name"
                           :input.sync="input.device_name"
                >
                </qdn-input>

                <qdn-input name="package_type"
                           label="Package type"
                           :input.sync="input.package_type"
                >
                </qdn-input>

                <qdn-input name="lot_quantity"
                           label="Lot quantity"
                           :input.sync="input.lot_quantity"
                >
                </qdn-input>

            </div>

            <div class="btn-group" data-toggle="buttons">
                <label>
                    <input type="radio"
                           value="true"
                           v-model="major"
                    > Major
                </label>

                <label>
                    <input type="radio"
                           value="false"
                           v-model="major"
                           checked
                    > Minor
                </label>

            </div>

            <div class="form__category">
                <div class="form__category--failure__mode">
                    <label>Failure Mode:
                        <multiselect
                                :selected.sync="input.failure_mode"
                                :options="category.failureMode"
                                :allow-empty="false"
                                class="multiselect__failure_mode"
                        />
                    </label>
                </div>

                <div class="form__category--discrepancy__category">
                    <label>Discrepancy Category:
                        <multiselect
                                :selected.sync="input.discrepancy_category"
                                :options="category.discrepanciesOption"
                                :allow-empty="false"
                                class="multiselect__discrepancy_category"
                        />
                    </label>
                </div>
            </div>

            <div class="form__problem_description">
                <label>Problem Description:</label>
                        <textarea class="form__textarea"
                                  rows="10"
                                  placeholder="Required input"
                                  v-model="input.problem_description"
                        ></textarea>
            </div>

            <div class="form__submit">
                <button class="form__submit--btn"
                        type="submit"
                        value="send"
                        @click.prevent="saveQdn"
                >
                    Submit <i class="fa fa-paper-plane"></i>
                </button>
            </div>
        </div>
    </form>
@endsection

@push('scripts')
  <script src="/js/vue-issue.js"></script>
@endpush
