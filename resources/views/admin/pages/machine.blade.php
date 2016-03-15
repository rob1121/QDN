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
    <h1>Machine List</h1>
    <div id="tbl-container">
        <ul class="list-group">
            <li class="list-group-item" v-for="todo in todos">
                <div class="row-fluid">
                    <div class="col-md-10"><span>@{{ todo.name | uppercase }}</span></div>
                    <div class="col-md-2">
                        <a  @click="editTodo($index)" class="text-primary"><i class="fa fa-edit"></i></a>
                        <a  @click="removeTodo($index)" class="text-danger"><i class="fa fa-trash"></i></a>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </li>
        </ul>
    </div>
    <input v-model="newTodo" v-on:keyup.enter="addTodo" class="input-lg form-control" placeholder="Input Machine Name">
</div>
@stop
@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/vue/1.0.17/vue.js"></script>
<script>
new Vue({
el: 'body',
data: {
newTodo: '',
todos: machines
},
methods: {
addTodo: function () {
var name = this.newTodo.trim()
if (name) {
this.todos.push({ name: name })
this.newTodo = ''
}
},
removeTodo: function (index) {
this.todos.splice(index, 1)
},
editTodo: function (index) {
this.newTodo = this.todos[index].name
this.todos.splice(index, 1)
}
}
})
</script>
@endpush