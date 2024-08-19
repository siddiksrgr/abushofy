<!DOCTYPE html>
<html>
<head>
	<title>Laporan Komplain</title>
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
            font-size: 13px;
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
    <p style="font-weight:bolder;margin-bottom: 10px;">Laporan Komplain <span style="float: right;font-weight:normal;font-size: 15px">Tanggal : {{\Carbon\Carbon::parse(now())->format('d-m-Y')}}</span></p>
    <hr>
    <table class="table">
			<tr>
                <th>No</th>
                <th>Kode Transaksi</th>
                <th>Kode Komplain</th>
                <th>Produk</th>
                <th>Jumlah</th>
                <th>Ukuran</th>
                <th>Bahan</th>
                <th>Alasan</th>
                <th>Status</th>
			</tr>
			@foreach($complains as $complain)
			<tr>
                <td>{{$loop->iteration}}</td>
                <td>{{ $complain->transaction_detail->transaction->code }}</td>
                <td>{{ $complain->complain_code }}</td>
                <td>{{ $complain->transaction_detail->product->name }}</td>
                <td>{{ $complain->quantity }} pcs</td>

                @if($complain->transaction_detail->clothing_size != null)
                    <td>{{ $complain->transaction_detail->clothing_size->size_name }}</td>
                @else 
                    <td>{{ $complain->transaction_detail->accessories_size->size_name }}</td>
                @endif

                <td>{{ $complain->transaction_detail->material}}</td>
                <td>{{ $complain->complain }}</td>
                <td>{{ $complain->status }}</td>
			</tr>
			@endforeach
	</table>
 
</body>
</html>