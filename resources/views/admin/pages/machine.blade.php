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
            <li class="list-group-item" v-for="machine in machines  | orderBy 'name'">
                <div class="row-fluid">
                    <div class="col-md-9"><span>@{{ machine.name | uppercase }}</span></div>
                    <div class="col-md-3">
                        <a  @click="editMachine(machine)" class="text-primary">
                            <span class="fa-stack fa-lg">
                              <i class="fa fa-circle fa-stack-2x"></i>
                              <i class="fa fa-edit fa-stack-1x fa-inverse"></i>
                            </span>
                        </a>
                        <a  @click="removeMachine(machine)" class="text-danger">
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
    <input v-model="newMachine" @keyup.enter="updateTable()" class="input-lg form-control" placeholder="Input Machine Name">
</div>
<div class="clearfix"></div>
@stop
@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/vue/1.0.17/vue.js"></script>
<script>
var machineTable = new Vue({
    el: 'body',
    data: {
        newMachine: '',
        machines: machines
    },
    methods: {
        addMachine: function (name) {
                this.machines.push({ name: name })
        },
        removeMachine: function(machine) {
            this.removeMachineTable(machine)
            this.alertMsg('Changes Saved!','Machine table are now updated','fa-save','ok')
        },
        editMachine: function (machine) {
            name = this.newMachine.trim()
            if (name) {
            this.updateMachineTable(name)
            }
            this.newMachine = machine.name
            this.removeMachineTable(machine)
        },
        updateTable: function() {
            var name = this.newMachine.trim()
            if (name) {
                this.updateMachineTable(name)
                machineTable.newMachine = ''
             }
        },
        updateMachineTable: function(name){
                $.ajax({
                url: '{{ route('updateMachineOptions') }}',
                type: 'get',
                data: {
                    name: name
                },
                success: function(data){
                       if (data == 'unique') {
                            machineTable.addMachine(name)
                            machineTable.alertMsg('Changes Saved!','Machine table are now updated','fa-save','ok')
                       } else {
                            machineTable.alertMsg('Warning!','Machine already exist','fa-chain-broken','yellow')
                       }
                }
            })
        },
        removeMachineTable: function(machine){
                $.ajax({
                url: '{{ route('removeMachineOptions') }}',
                type: 'get',
                data: {
                    name: machine.name
                },
                success: function(data){
                    machineTable.machines.$remove(machine)
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