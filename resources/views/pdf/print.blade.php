<!DOCTYPE html>
<html>
    <head>
        <TITLE>QDN</TITLE>
        <style>
        .logo {
        background-color: #800;
        color: #fff;
        font-weight: bold;
        text-align: center;
        margin:auto auto 10px auto;
        width: 20%;
        }
        #section {
        border-collapse: collapse;
        font-size: 10px;
        width: 100%;
        }
        
        #section tr td {
        border:1px solid black;
        }
        
        #section table {
        border-collapse: collapse;
        width: 100%;
        }
        #section table tr td#comment {
        text-align: center;
        padding-left:42px;
        padding-right:42px;
        padding-top:24px;
        }
        #section table tr td {
        border-collapse: collapse;
        border:0px;
        width: 100%;
        padding-bottom:10px;
        }
        #section table tr td#question {
        width: 40%;
        font-weight: bold;
        text-align: right;
        padding-bottom:0px;
        }
        #section table tr td#answer {
        width: 60%;
        text-align: left;
        padding-bottom:0px;
        }
        #section table tr td#who,
        #section table tr td#what-label,
        #section table tr td#date {
        width: 50%;
        text-align: center;
        border-left: 1px solid black;
        border-top: 1px solid black;
        }
        #answer,
        #question {
        vertical-align: text-top;
        }
        .title {
        font-weight: bold;
        color:#800;
        padding-bottom: 8px;
        }

        #what {
            min-height: 100px;
        }
        </style>
    </head>
    <body>
        <h3 class="logo">{{ Str::upper('telford') }}</h3>
        {{-- first section --}}
        <table id="section">
            <tr><td colspan="3">
                <table>
                    <tr>
                        <td class="title" colspan='6'>
                            {{ Str::upper('PRODUCT DESCRIPTION/ PROBLEM DETAILS') }}
                        </td>
                    </tr>
                    <tr>
                        <td colspan='6'>
                            <Table>
                                <tr>
                                    <td id = "question">Customer: </td>
                                    <td id = "answer">{{ $qdn->customer }}</td>
                                    <td id = "question">Job Order No.:</td>
                                    <td id = "answer">{{ $qdn->job_order_number }}</td>
                                    <td id = "question">QDN No.:</td>
                                    <td
                                        id = "answer"
                                        style='color:#800;font-weight:bold'
                                        >{{ $qdn->control_id }}
                                    </td>
                                </tr>
                                
                                <tr>
                                    <td id = "question">Package Type: </td>
                                    <td id = "answer">{{ $qdn->package_type }}</td>
                                    <td id = "question">Machine:</td>
                                    <td id = "answer">{{ Str::upper($qdn->machine) }}</td>
                                    <td id = "question">Team Responsible:</td>
                                    <td id = "answer">
                                        {!! implode("<br>",$department) !!}
                                    </td>
                                </tr>
                                
                                <tr>
                                    <td id = "question">Device Name: </td>
                                    <td id = "answer">{{ $qdn->device_name }}</td>
                                    <td id = "question">Station:</td>
                                    <td id = "answer">{{ Str::upper($qdn->station) }}</td>
                                    <td id = "question">Issued By:</td>
                                    <td id = "answer">
                                        {{ $qdn->involvePerson()->first()->originator_name }}
                                    </td>
                                </tr>
                                
                                <tr>
                                    <td id = "question">Lot ID No.: </td>
                                    <td id = "answer">{{ $qdn->lot_id_number }}</td>
                                    <td id = "question">Major:</td>
                                    <td id = "answer">
                                        {{
                                        $qdn->major == "major"
                                        ? '[&nbsp;x&nbsp;]'
                                        : '[&nbsp;&nbsp;&nbsp;&nbsp;]'
                                        }}
                                    </td>
                                    <td id = "question">Issued To:</td>
                                    <td id = "answer">
                                        {!!
                                        implode("<br>",array_flatten(
                                        $qdn->involvePerson()
                                        ->select('receiver_name')
                                        ->get()
                                        ->toArray())
                                        )
                                        !!}
                                    </td>
                                </tr>
                                
                                <tr>
                                    <td id = "question">Lot Quantity.: </td>
                                    <td id = "answer">{{ $qdn->lot_quantity }}</td>
                                    <td id = "question">Minor:</td>
                                    <td id = "answer">
                                        <?=
                                        $qdn->major == "minor"
                                        ? '[&nbsp;x&nbsp;]'
                                        : '[&nbsp;&nbsp;&nbsp;&nbsp;]';
                                        ?>
                                    </td>
                                    <td id = "question">Date and Time:</td>
                                    <td id = "answer">{{ $qdn->created_at }}</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td id="comment" colspan="6">
                            {!!
                            $qdn->problem_description == ""
                            ? "<br/><br/>"
                            : $qdn->problem_description
                            !!}
                        </td>
                    </tr>
                </table>
            </td></tr>
            <tr>
                <td colspan="3">
                    
                    {{-- SECOND SECTION --}}
                    <table>
                        <tr>
                            <td class="title" colspan='6'>
                                {{ Str::upper('DISPOSITION:') }}
                            </td>
                        </tr>
                        <tr>
                            @foreach ($disposition_check as $dispo)
                            <td>
                                {{
                                $qdn->disposition == $dispo
                                ? '[&nbsp;x&nbsp;]'
                                : '[&nbsp;&nbsp;&nbsp;&nbsp;]'
                                }}
                                <strong>{{ Str::upper($dispo) }}</strong>
                            </td>
                            @endforeach
                        </tr>
                        
                    </table>
                </td>
            </tr>
            <tr>
                <td colspan="3">
                    {{-- THIRD SECTION --}}
                    <table>
                        <tr>
                            <td class="title" colspan='6'>
                                {{ Str::upper('CAUSE OF DEFECTS/ FAILURE:') }}
                            </td>
                        </tr>
                        <tr>
                            @foreach ($cod_check as $cod_check)
                            
                            <td
                                @if ($cod_check == 'quality assurance')
                                style="width:120%"
                                @endif
                                >
                                {{
                                $qdn->CauseOfDefect->cause_of_defect == $cod_check
                                ? '[&nbsp;x&nbsp;]'
                                : '[&nbsp;&nbsp;&nbsp;&nbsp;]'
                                }}
                                <strong>{{ Str::upper($cod_check) }}</strong>
                            </td>
                            @endforeach
                        </tr>
                        <tr>
                            <td id="comment" colspan="6">
                                {{ $qdn->CauseOfDefect->cause_of_defect_description }}
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            
            <tr class="bordered">
                <td class="title" colspan='6'>
                    {{ Str::upper('CONTAINMENT ACTION/S:') }}
                </td>
                </tr>
                            <tr>
                            <td id="what-label" colspan="6" style="text-align: center"><strong>WHAT</strong></td>
                            <td id= "who"><strong>WHO</strong></td>
                            <td id= "date"><strong>WHEN</strong></td>
                        </tr>
                        <tr>
                            <td colspan="6" id="what">{{ $qdn->containmentAction->what }}</td>
                            <td id= "who">{{ $qdn->containmentAction->who }}</td>
                            <td id= "date">
                                {{
                                Carbon::parse($qdn->containmentAction->updated_at)
                                ->format('m/d/Y')
                                }}
                            </td>
            </tr>
            <tr>
                <td>
                    
                    {{-- FIFTH SECTION --}}
                    <table>
                        <tr>
                            <td class="title" colspan='6'>
                                {{ Str::upper('CORRECTIVE ACTION/S:') }}
                            </td>
                            </tr>
                            <tr>
                            <td id="what-label" colspan="6" style="text-align: center"><strong>WHAT</strong></td>
                            <td id= "who"><strong>WHO</strong></td>
                            <td id= "date"><strong>WHEN</strong></td>
                        </tr>
                        <tr>
                            <td colspan="6" id="what">{{ $qdn->correctiveAction->what }}</td>
                            <td id= "who">{{ $qdn->correctiveAction->who }}</td>
                            <td id= "date">
                                {{
                                Carbon::parse($qdn->correctiveAction->updated_at)
                                ->format('m/d/Y')
                                }}
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td>
                    {{-- SIXTH SECTION --}}
                    <table>
                        <tr>
                            <td class="title" colspan='6'>
                                {{ Str::upper('PREVENTIVE ACTION/S:') }}
                            </td>
                            </tr>
                            <tr>
                            <td id="what-label" colspan="6" style="text-align: center"><strong>WHAT</strong></td>
                            <td id= "who"><strong>WHO</strong></td>
                            <td id= "date"><strong>WHEN</strong></td>
                        </tr>
                        <tr>
                            <td colspan="6" id="what">{{ $qdn->preventiveAction->what }}</td>
                            <td id= "who">{{ $qdn->preventiveAction->who }}</td>
                            <td id= "date">
                                {{
                                Carbon::parse($qdn->preventiveAction->updated_at)
                                ->format('m/d/Y')
                                }}
                            </td>
                        </tr>
                    </table>
    </td>
</tr>
<tr>
    <td>
        
        <table>
            <tr>
                <td class="title">{{ Str::upper('approvals:') }}</td>
            </tr>
            <tr>
                @foreach ($approvers as $approver)
                <td style="text-align: center;">
                    __________________________ <br>
                    {{ Str::upper($approver) }}</td>
                @endforeach
            </tr>
        </table>
    </td>
</tr>
<tr>
    <td>
        <table>
            <tr>
                <td class="title">{{ Str::upper('verified by:') }}</td>
            </tr>
            <tr>
                                <td style="text-align: left;width:60%;padding-left:32px">Verified By:_____________________________</td>
                <td style="text-align: left;width:40%">Date:________________________</td>
            </tr>
        </table>
    </td>
</tr>
</table>
</body>
</html>