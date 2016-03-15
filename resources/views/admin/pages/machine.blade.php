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
    <h1>Machine List</h1>
    <div id="tbl-container">
        <ul class="list-group">
            <li class="list-group-item" v-for="machine in machines">
                <div class="row-fluid">
                    <div class="col-md-10"><span>@{{ machine.name | uppercase }}</span></div>
                    <div class="col-md-2">
                        <a  @click="editMachine($index)" class="text-primary"><i class="fa fa-edit"></i></a>
                        <a  @click="removeMachine($index)" class="text-danger"><i class="fa fa-trash"></i></a>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </li>
        </ul>
    </div>
    <input v-model="newMachine" @keyup.enter="addMachine" class="input-lg form-control" placeholder="Input Machine Name">
</div>
<div class="clearfix"></div>
@stop
@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/vue/1.0.17/vue.js"></script>
<script>
new Vue({
    el: 'body',
    data: {
        newMachine: '',
        machines: machines
    },
    methods: {
        addMachine: function () {
            var name = this.newMachine.trim()
            if (name) {
                this.machines.push({ name: name })
                this.updateTable(name)
                this.newMachine = ''
            }
        },
        removeMachine: function (index) {
            this.machines.splice(index, 1)
        },
        editMachine: function (index) {
            this.addMachine()
            this.newMachine = this.machines[index].name
            this.machines.splice(index, 1)
        },
        updateTable: function(name) {
            $.ajax({
            url: '/dashboard/machines-update',
            type: 'get',
            data: {
                machine: name
            },
            success: function(data){
                alert(data);
            },
            error: function() {
                alert('error');
            }
        })
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