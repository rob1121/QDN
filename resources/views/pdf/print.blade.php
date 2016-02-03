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

    table {
        font-size: 10px;
        width: 100%;
    }

    #question {
        font-weight: bold;
        text-align: right;
    }

    #answer {
        text-align: left;
    }

    #answer, 
    #question {
        vertical-align: text-top;
        width: 100%;
        padding-top: 8px;
    }

    .section {
        border:1px solid black;
    }

    .title {
        font-weight: bold;
        color:#800;
    }
    </style>
</head>
<body>  

<h3 class="logo">{{ Str::upper('telford') }}</h3>
<table>
    {{-- first section --}}
    <tr>
        <td class="title" colspan='6'>
            {{ Str::upper('PRODUCT DESCRIPTION/ PROBLEM DETAILS') }}
        </td>
        <td style="border:1px solid black">
        <Table>
            <tr>
                <td id="question">Customer: </td>
                <td id="answer">{{ $qdn->customer }}</td>
                <td id="question">Job Order No.:</td>
                <td id="answer">{{ $qdn->job_order_number }}</td>
                <td id="question">QDN No.:</td>
                <td id="answer" style='color:#800;font-weight:bold'>{{ $qdn->control_id }}</td>
            </tr>
            
            <tr>
                <td id="question">Package Type: </td>
                <td id="answer">{{ $qdn->package_type }}</td>
                <td id="question">Machine:</td>
                <td id="answer">{{ Str::upper($qdn->machine) }}</td>
                <td id="question">Dept. / Team Responsible:</td>
                <td id="answer"></td>
            </tr>
            
            <tr>
                <td id="question">Device Name: </td>
                <td id="answer">{{ $qdn->device_name }}</td>
                <td id="question">Station:</td>
                <td id="answer">{{ Str::upper($qdn->station) }}</td>
                <td id="question">Issued By:</td>
                <td id="answer"></td>
            </tr>
            
            <tr>
                <td id="question">Lot ID No.: </td>
                <td id="answer">{{ $qdn->lot_id_number }}</td>
                <td id="question">Major:</td>
                <td id="answer">
                    <?=$qdn->major == "major" ? '[x]' : '[&nbsp;&nbsp;]';?>
                </td>
                <td id="question">Issued To:</td>
                <td id="answer"></td>
            </tr>
            
            <tr>
                <td id="question">Lot Quantity.: </td>
                <td id="answer">{{ $qdn->lot_quantity }}</td>
                <td id="question">Minor:</td>
                <td id="answer">
                    <?=$qdn->major == "minor" ? '[x]' : '[&nbsp;&nbsp;]';?>
                </td>
                <td id="question">Date and Time:</td>
                <td id="answer">{{ $qdn->created_at }}</td>
            </tr>
            </table>
            </td>
        </td>
    </tr>
</table>
</body>
</html>