<!DOCTYPE html>
<html>
<head>
	<title>Laporan Pengiriman</title>
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
    <p style="font-weight:bolder;margin-bottom: 10px;">Laporan Pengiriman <span style="float: right;font-weight:normal;font-size: 15px">Tanggal : {{\Carbon\Carbon::parse(now())->format('d-m-Y')}}</span></p>
    <hr>
    <table class="table">
			<tr>
                <th>No</th>
                <th scope="col">Kode Transaksi</th>
                <th scope="col">Kode Komplain</th>
                <th scope="col">Resi</th>
                <th scope="col">Status</th>
                <th scope="col">Tanggal Dikirim</th>
                <th scope="col">Tanggal Terkirim</th>
			</tr>
			@foreach($shippings as $shipping)
			<tr>
                <td>{{$loop->iteration}}</td>
                <td>{{$shipping->confirmation->transaction->code}}</td>

                @if($shipping->complain)
                <td>{{$shipping->complain->complain_code}}</td>
                @else
                <td> - </td>
                @endif

                <td>{{$shipping->confirmation->transaction->resi}}</td>
                <td>{{$shipping->status}}</td> 
                <td>{{ \Carbon\Carbon::parse($shipping->created_at)->format('d-m-Y, H:i') }}</td> 

                @if($shipping->status == 'terkirim')
                <td>{{ \Carbon\Carbon::parse($shipping->updated_at)->format('d-m-Y, H:i') }}</td>
                @else
                <td>-</td>
                @endif
			</tr>
			@endforeach
	</table>
 
</body>
</html>