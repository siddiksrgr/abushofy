<!DOCTYPE html>
<html>
<head>
	<title>Laporan Pembayaran</title>
    <link rel="stylesheet" type="text/css" href="style.css">

    <style type="text/css">
        .page-break {
            page-break-before: always;
        }

        .table{
            border-collapse: collapse;
            width: 100%;
            
        }
        .table tr th{
            background: #e6e8e6;
            font-weight: bolder;
        }
        
        .table, th, td {
            padding: 5px 5px;
            text-align: left;
            border: 1px solid black;
        }
        body {
            line-height: 1;
        }
    </style>
</head>
<body> 
    <p style="font-weight:bolder;margin-bottom: 10px;">Laporan Pembayaran <span style="float: right;font-weight:normal;font-size: 15px">Tanggal : {{\Carbon\Carbon::parse(now())->format('d-m-Y')}}</span></p>
    <hr>
    <table class="table">
			<tr>
                <th>No</th>
                <th scope="col">Kode Transaksi</th>
                <th scope="col">Total Harga</th>
                <th scope="col">DP</th>
                <th scope="col">Pelunasan</th>
                <th scope="col">Status</th>
			</tr>
			@foreach($confirmations as $confirmation)
			<tr>
                <td>{{$loop->iteration}}</td>
                <td>{{$confirmation->transaction->code}}</td>
                <td>@currency($confirmation->transaction->total_price)</td>
                
                <!-- DP -->
                @if($confirmation->transaction->description == 'pre-order' && $confirmation->down_payment != null)
                <td>lunas</td>
                @else
                <td> - </td>
                @endif

                <!-- pelunasan -->
                @if($confirmation->paid_off != null)
                <td>lunas</td>
                @else
                <td> - </td>
                @endif

                <td>{{ $confirmation->transaction->payment_status }}</td>
			</tr>
			@endforeach
	</table>
    <p style="font-weight:bolder;margin-top: 10px;">Pendapatan : <span style="font-weight:normal;">@currency($incomes)</span></p>
 
</body>
</html>