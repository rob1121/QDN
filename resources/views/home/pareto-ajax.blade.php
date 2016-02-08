@foreach ($tbl as $row)
    <tr>
        <td
            @if ($column == 'control_id')
                class="info"
            @endif
        ><a href="{{ route('qdn_link', ['slug'=>$row->slug]) }}">{{ $row->control_id }}</a></td>

        <td
            @if ($column == 'problem_description')
                class="info"
            @endif
        >{{ Str::title($row->problem_description) }}</td>

        <td
            @if ($column == 'discrepancy_category')
                class="info"
            @endif
        >{{ Str::title($row->discrepancy_category) }}</td>

        <td
            @if ($column == 'failure_mode')
                class="info"
            @endif
         >{{ Str::title($row->failure_mode) }}</td>

        <td
            @if ($column == 'created_at')
                class="info"
            @endif
        >{{ Str::title($row->created_at) }}</td>

        <td>@foreach ($row->involvePerson()->select('receiver_name')->get() as $name)
            <li>{{ $name->receiver_name }}</li>
        @endforeach</td>

    </tr>

@endforeach