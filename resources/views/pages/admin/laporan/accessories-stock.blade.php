<!DOCTYPE html>
<html>
<head>
	<title>Laporan Stok Aksesoris</title>
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
    <p style="font-weight:bolder;margin-bottom: 10px;">Laporan Stok Aksesoris <span style="float: right;font-weight:normal;font-size: 15px">Tanggal : {{\Carbon\Carbon::parse(now())->format('d-m-Y')}}</span></p>
    <hr>
    <table class="table">
			<tr>
                <th>No</th>
                <th>Kategori</th>
                <th>Produk</th>
                <th>Ukuran</th>
                <th>Stok</th>
			</tr>
			@foreach($accessories_stocks as $accessories_stock)
			<tr>
                <td>{{$loop->iteration}}</td>
                <td>{{$accessories_stock->accessories_size->product->category->name_category}} ({{$accessories_stock->accessories_size->product->category->main_category}} {{$accessories_stock->accessories_size->product->category->gender_category}})</td>
				<td>{{$accessories_stock->accessories_size->product->name}}</td>
                <td>{{$accessories_stock->accessories_size->size_name}}</td>
                <td>{{$accessories_stock->stock}}</td>
			</tr>
			@endforeach
	</table>
 
</body>
</html>