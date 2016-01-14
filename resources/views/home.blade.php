@extends('layouts.app')
@section('content')

<!-- Demo content -->
<div class="container">
@include('errors.validationErrors')
    <p class="h2">Counts:</p>
    <ul class="nav nav-pills">
        <li class="h3">Today: {{ $qdn->count() }}</li>
        <li class="h3">This Week: ###</li>
        <li class="h3">This Month: ####</li>
        <li class="h3">This Year: #####</li>
    </ul>
</div>

<div class="container">
    <table class="table table-striped table-hover">

        <thead>
            <tr>
                <th></th>
            </tr>
        </thead>

        <tbody>
            @foreach ($qdn as $row)
                <tr>
                    <td>
                        <a href="{{ route('qdn_form_link', ['slug' => $row->slug]) }}">
                            {{ $row->control_id }}
                        </a>
                    </td>
                    <td>{{ $row->discrepancy_category }}</td>
                    <td>{{ $row->failure_mode }}</td>
                    <td>{{ $row->quantity }}</td>
                    <td>{{ $row->customer }}</td>
                    <td>{{ $row->created_at }}</td>
                    <td>
                        @foreach ($row->involvePerson as $qdn)
                            <li>{{ $qdn->receiver_name }}</li>
                        @endforeach
                    </td>
                </tr>
            @endforeach
        </tbody>

    </table>
</div>
@endsection