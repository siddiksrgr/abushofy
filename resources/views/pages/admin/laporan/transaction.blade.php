<!DOCTYPE html>
<html>
<head>
	<title>Laporan Transaksi</title>
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
    <p style="font-weight:bolder;margin-bottom: 10px;">Laporan Transaksi <span style="float: right;font-weight:normal;font-size: 15px">Tanggal : {{\Carbon\Carbon::parse(now())->format('d-m-Y')}}</span></p>
    <hr>
    <table class="table">
			<tr>
                <th>No</th>
                <th scope="col">Kode Transaksi</th>
                <th scope="col">User</th>
                <th scope="col">Total Harga</th>
                <th scope="col">Status Bayar</th>
                <th scope="col">Status Transaksi</th>
                <th scope="col">Status Kirim</th>
			</tr>
			@foreach($transactions as $transaction)
			<tr>
                <td>{{$loop->iteration}}</td>
                <td>{{$transaction->code}}</td>
                <td>{{$transaction->user->name}}</td>
                <td>@currency($transaction->total_price)</td>
                <td>{{$transaction->payment_status}}</td>
                <td>{{$transaction->transaction_status}}</td>
                <td>{{$transaction->shipping_status}}</td>
			</tr>
			@endforeach
	</table>
 
</body>
</html>