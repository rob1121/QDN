<?php $a = 1;?>
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
            <li class="list-group-item" v-for="customer in customers">
                <div class="row-fluid">
                    <div class="col-md-10"><span>@{{ customer.customer | uppercase }}</span></div>
                    <div class="col-md-2">
                        <a  @click="editCustomer($index)" class="text-primary"><i class="fa fa-edit"></i></a>
                        <a  @click="removeCustomer($index)" class="text-danger"><i class="fa fa-trash"></i></a>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </li>
        </ul>
    </div>
    <input v-model="newCustomer" @keyup.enter="addCustomer" class="input-lg form-control" placeholder="Input Customer Name">
</div>
@stop
@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/vue/1.0.17/vue.js"></script>
<script>
new Vue({
    el: 'body',
    data: {
        newCustomer: '',
        customers: customers
    },
    methods: {
        addCustomer: function() {
            var customer = this.newCustomer.trim()
            if (customer) {
                this.customers.push({
                    customer: customer
                })
                this.newCustomer = ''
            }
        },
        removeCustomer: function(index) {
            this.customers.splice(index, 1)
        },
        editCustomer: function(index) {
            this.newCustomer = this.customers[index].customer
            this.customers.splice(index, 1)
        }
    }
})
</script>
@endpush