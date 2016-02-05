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

        table#frame {
            border-collapse: collapse;
            width: 100%;
            font-size: 10px;
        }

        table#frame,
        #frame th,
        #frame td {
            border-collapse: collapse;
            border: 1px solid #000;
            vertical-align: bottom;
        }
        
        #frame table {
            border-collapse: collapse;
            width: 100%;
        }

        #frame table,
        #frame table th,
        #frame table td {
            border: 0px;
        }

        #frame .label {
            width: 40%;
            text-align:right;
            font-weight: bold;
        }

        #frame .field {
            width: 60%;
            text-align:left;

        }

        #frame td.sec1-col-1,
        #frame td.sec1-col-2,
        #frame td.sec1-col-3,
        #frame td.title,
        #frame td.comment,
        #frame td {
            border:0px;
        }

        #frame td {
            border-top: 1px solid #000;
            border-bottom: 1px solid #000;
        }

        #frame tr td {
            border-top: 0px;
        }

        #frame .title {
            border-top: 1px solid black;
            font-weight: bold;
            color: #800;
            padding-bottom: 8px;
        }

        .sec1-col-1 {
            width: 37%;

        }

        .sec1-col-2 {
            width: 25%;
        }

        .sec1-col-3 {
            width: 38%;
        }

        .sec1-con-s,
        .sec1-con-m {
            height: 110px;
            text-align: center;
        }

        .s2,
        .s3 {
            padding-left: 12px;
            height: 50px;
        }


        #frame .comment{
            text-align: center;
            padding: 0px 32px 32px 32px;
            border-bottom: 1px solid black;
        }

        #frame #s2,
        #frame #s3 {
            border:0px;
        }

        .s4 {
            height: 100px;
            overflow: hidden;
        }


        .approval-by,
        .verified-by {
            height: 80px;
            overflow: hidden;
        }

        #frame .s4 table tr td {
            text-align: center;
        }
        
        #frame .s4 table tr td.what {
            text-align: left;
            padding:5px;
            padding-top:12px;
        }
        
        #frame .s4 table tr td.who,
        #frame .s4 table tr td.when {
            padding:5px;
            padding-top:12px;
        }

        #frame td#comp-name {
            border:0px;
            text-align: left;
        }

        #frame td#rev {
            border:0px;
            text-align: right;
        }

        </style>
    </head>
    <body>
        <h3 class="logo">{{ Str::upper('telford') }}</h3>
        <table id="frame">
            <tr>
                <td colspan="3" class="title">
                {{ 
                    Str::upper('PRODUCT DESCRIPTION/ PROBLEM DETAILS:') 
                }}
                </td>
            </tr>
            <tr>
                <td class="sec1-col-1">
                <div class="sec1-con-m">
                    <table>
                        <tr>
                            <td class="label">Customer: </td>
                            <td class="field">{{ $qdn->customer }}</td>
                        </tr>
                        <tr>
                            <td class = "label">Package Type: </td>
                            <td class = "field">{{ $qdn->package_type }}
                        </tr>
                        <tr>
                            <td class = "label">Device Name: </td>
                            <td class = "field">{{ $qdn->device_name }}</td>
                        </tr>
                        <tr>
                            <td class = "label">Lot ID No.: </td>
                            <td class = "field">{{ $qdn->lot_id_number }}</td>
                            </tr>
                            <tr>
                            <td class = "label">Lot Quantity.: </td>
                            <td class = "field">{{ $qdn->lot_quantity }}</td>
                        </tr>
                    </table>
                </div>
                </td>

                <td class="sec1-col-2">
                <div class="sec1-con-s">
                    <table>
                        <tr>
                             <td class = "label">Job Order No.:</td>
                            <td class = "field">{{ $qdn->job_order_number }}</td>
                        </tr>
                        <tr>
                            <td class = "label">Machine:</td>
                            <td class = "field">{{ Str::upper($qdn->machine) }}</td>
                        </tr>
                        <tr>
                            <td class = "label">Station:</td>
                            <td class = "field">{{ Str::upper($qdn->station) }}</td>
                            </tr>
                            <tr>
                            <td class = "label">Major:</td>
                            <td class = "field">
                                {{
                                $qdn->major == "major"
                                ? '[&nbsp;x&nbsp;]'
                                : '[&nbsp;&nbsp;&nbsp;&nbsp;]'
                                }}
                            </td>
                            </tr>
                            <tr>
                            <td class = "label">Minor:</td>
                            <td class = "field">
                                <?=
                                $qdn->major == "minor"
                                ? '[&nbsp;x&nbsp;]'
                                : '[&nbsp;&nbsp;&nbsp;&nbsp;]';
                                ?>
                            </td>
                            </tr>
                    </table>
                </div>
                </td>

                <td class="sec1-col-3">
                    <div class="sec1-con-m">
                        <table>
                            <tr>
                                
                                <td class = "label">QDN No.:</td>
                                <td
                                    class = "field"
                                    style='color:#800;font-weight:bold'
                                    >{{ $qdn->control_id }}
                                </td>
                            </tr>
                            <tr>
                                <td class = "label">Team Responsible:</td>
                                <td class = "field">
                                    {!! implode("<br>",$department) !!}
                                </td></tr>
                                <tr>
                                <td class = "label">Issued By:</td>
                                <td class = "field">
                                    {{ $qdn->involvePerson()->first()->originator_name }}
                                </td></tr>
                                <tr>
                                <td class = "label">Issued To:</td>
                                <td class = "field">
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
                                <td class = "label">Date and Time:</td>
                                <td class = "field">{{ $qdn->created_at }}</td>
                                </tr>
                        </table>
                    </div>
                </td>
            </tr>
            <tr>
                <td colspan="3" class="comment">
                    {!!
                        $qdn->problem_description == ""
                            ? "<br/><br/>"
                            : $qdn->problem_description
                    !!}
                </td>
            </tr>
            <tr>
                <td class="title" colspan='3'>
                    {{ Str::upper('DISPOSITION:') }}
                </td>
            </tr>
            <tr>
                <td colspan="3"><div class="s2">
                      {{-- SECOND SECTION --}}
                    <table>
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
                </div></td>
            </tr>
            <tr>
                <td colspan='3' class="title">
                    {{ Str::upper('CAUSE OF DEFECTS/ FAILURE:') }}
                </td>
            </tr>
             {{-- THIRD SECTION --}}
              <tr>
                <td colspan="3" id="s3"><div class="s3">
                    <table>
                      
                        <tr>
                            @foreach ($cod_check as $cod_check)
                            
                            <td>
                                {{
                                $qdn->CauseOfDefect->cause_of_defect == $cod_check
                                ? '[&nbsp;x&nbsp;]'
                                : '[&nbsp;&nbsp;&nbsp;&nbsp;]'
                                }}
                                <strong>{{ Str::upper($cod_check) }}</strong>
                            </td>
                            @endforeach
                        </tr>
                    </table>
                </div></td>
            </tr>
                       
                        <tr>
                            <td class="comment" colspan="3">
                                {{ $qdn->CauseOfDefect->cause_of_defect_description }}
                            </td>
                        </tr>
            <tr>
                <td class="title" colspan='3'>
                    {{ Str::upper('containment action:') }}
                </td>
            </tr>
            <tr>
                <td colspan="2"><div class="s4">
                    <table>
                        <tr>
                            <td><strong>WHAT</strong></td>
                        </tr>
                        <tr>
                            <td class="what">{{ $qdn->containmentAction->what }}</td>
                        </tr>
                    </table>
                </div></td>


                <td><div class="s4">
                    <table>
                        <tr>
                            <td style="width:50%"><strong>WHO</strong></td>
                            <td style="width:50%"><strong>WHEN</strong></td>
                        </tr>
                        <tr>
                            <td class="who">{{ $qdn->containmentAction->who }}</td>                            <td class="when">{{
                                Carbon::parse($qdn->containmentAction->updated_at)
                                ->format('m/d/Y')
                                }}</td>
                        </tr>
                    </table></div></td>

</tr>
            
            <tr>
                <td class="title" colspan='3'>
                    {{ Str::upper('corrective action:') }}
                </td>
            </tr>
            <tr>
                <td colspan="2"><div class="s4">
                    <table>
                        <tr>
                            <td><strong>WHAT</strong></td>
                        </tr>
                        <tr>
                            <td class="what">{{ $qdn->correctiveAction->what }}</td>
                        </tr>
                    </table>
                </div></td>


                <td><div class="s4">
                    <table>
                        <tr>
                            <td style="width:50%"><strong>WHO</strong></td>
                            <td style="width:50%"><strong>WHEN</strong></td>
                        </tr>
                        <tr>
                            <td class="who">{{ $qdn->correctiveAction->who }}</td>                            <td class="when">{{
                                Carbon::parse($qdn->correctiveAction->updated_at)
                                ->format('m/d/Y')
                                }}</td>
                        </tr>
                    </table></div></td>

</tr>

            <tr>
                <td class="title" colspan='3'>
                    {{ Str::upper('preventive action:') }}
                </td>
            </tr>
            <tr>
                <td colspan="2"><div class="s4">
                    <table>
                        <tr>
                            <td><strong>WHAT</strong></td>
                        </tr>
                        <tr>
                            <td class="what">{{ $qdn->preventiveAction->what }}</td>
                        </tr>
                    </table>
                </div></td>


                <td><div class="s4">
                    <table>
                        <tr>
                            <td style="width:50%"><strong>WHO</strong></td>
                            <td style="width:50%"><strong>WHEN</strong></td>
                        </tr>
                        <tr>
                            <td class="who">{{ $qdn->preventiveAction->who }}</td>                            <td class="when">{{
                                Carbon::parse($qdn->preventiveAction->updated_at)
                                ->format('m/d/Y')
                                }}</td>
                        </tr>
                    </table></div></td>

</tr>
            <tr>
                <td colspan='3' class="title">
                    {{ Str::upper('approvals:') }}
                </td>
            </tr>
            <tr>
                <td colspan="3"><div class="approval-by" >
                            <table>
            <tr>
                @foreach ($approvers as $approver)
                <td style="text-align: center; padding-top:40px">
                    __________________________ <br>
                    {{ Str::upper($approver) }}</td>
                @endforeach
            </tr>
        </table></div>
                </td>
            </tr>
            <tr>
                <td colspan='3' class="title">
                    {{ Str::upper('verified by:') }}
                </td>
            </tr>

            <tr>
                <td colspan="3"><div class="verified-by">
                     <table>
            <tr>
                                <td style="text-align: left;width:60%;padding-left:32px;padding-top: 40px">Verified By:_____________________________</td>
                <td style="text-align: left;width:40%">Date:________________________</td>
            </tr>
        </table>
                </div></td>
            </tr>

        </table>
        <table id="frame" style="border:0px">
                        <tr>
                <td id="comp-name" colspan="2" style="border:0px">Telford Svc. Phils Inc.</td>
                <td id="rev" style="border:0px">Rev. ##</td>
            </tr>
        </table>
    </body>
</html>