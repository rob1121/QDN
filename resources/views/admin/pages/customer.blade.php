@extends('admin.main')
@push('styles')
<style type="text/css">
    table {
        background-color: #fff;
    }
    #tbl-container {
        overflow: auto;
        height:300px;
        margin-bottom:32px;
    }
    #tbl-container::-webkit-scrollbar {
        width: 5px;
    }
    #tbl-container::-webkit-scrollbar-track {
        -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.3);
        border-radius: 10px;
    }
    #tbl-container::-webkit-scrollbar-thumb {
        border-radius: 10px;
        -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.5);
    }

</style>
@endpush
@section('content')
<div class="col-md-6 col-md-offset-3">
    <h1>Customer List</h1>
    <div id="tbl-container">
        <ul class="list-group">
            <li class="list-group-item" v-for="customer in customers  | orderBy 'customer' ">
                <div class="row-fluid">
                    <div class="col-md-9"><span>@{{ customer.customer | uppercase }}</span></div>
                    <div class="col-md-3">
                        <a  @click="editCustomer(customer)" class="text-primary">
                            <span class="fa-stack fa-lg">
                              <i class="fa fa-circle fa-stack-2x"></i>
                              <i class="fa fa-edit fa-stack-1x fa-inverse"></i>
                            </span>
                        </a>
                        <a  @click="removeCustomer(customer)" class="text-danger">
                            <span class="fa-stack fa-lg">
                              <i class="fa fa-circle fa-stack-2x"></i>
                              <i class="fa fa-trash fa-stack-1x fa-inverse"></i>
                            </span>
                        </a>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </li>
        </ul>
    </div>
    <input v-model="newCustomer" @keyup.enter="updateTable()" class="input-lg form-control" placeholder="Input Customer Name">
</div>
<div class="clearfix"></div>
@stop
@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/vue/1.0.17/vue.js"></script>
<script>
var customerTable = new Vue({
    el: 'body',
    data: {
        newCustomer: '',
        customers: customers
    },
    methods: {
        addCustomer: function (customer) {
                this.customers.push({ customer: customer })
        },
        removeCustomer: function(customer) {
            this.removeCustomerTable(customer)
            this.alertMsg('Successfully removed!','This action cannot be undo','fa-save','error')
        },
        editCustomer: function (customer) {
            name = this.newCustomer.trim()
            if (name) {
            this.updateCustomerTable(name)
            }
            this.newCustomer = customer.customer
            this.removeCustomerTable(customer)
        },
        updateTable: function() {
            var name = this.newCustomer.trim()
            if (name) {
                this.updateCustomerTable(name)
                this.newCustomer = ''
             }
        },
        updateCustomerTable: function(customer){
                $.ajax({
                url: '{{ route('updateCustomerOptions') }}',
                type: 'get',
                data: {
                    customer: customer
                },
                success: function(data){
                       if (data == 'unique') {
                            customerTable.addCustomer(customer)
                            customerTable.alertMsg('Changes Saved!','Customer Table are now updated','fa-save','ok')
                       } else {
                            customerTable.alertMsg('Warning!','Customer already exist','fa-chain-broken','yellow')
                       }
                }
            })
        },
        removeCustomerTable: function(customer){
                $.ajax({
                url: '{{ route('removeCustomerOptions') }}',
                type: 'get',
                data: {
                    customer: customer.customer
                },
                success: function(data){
                    customerTable.customers.$remove(customer)
                }
            })
        },
        alertMsg: function(title, info, icon, themes){
            //display alert
            $.amaran({
                'theme': 'awesome ' + themes,
                'content': {
                    title: title,
                    message: '',
                    info: info,
                    icon: 'fa ' + icon
                },
                'position': 'bottom right',
                'outEffect': 'fadeOut'
            });
        }
    }
})
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
</script>
@endpush