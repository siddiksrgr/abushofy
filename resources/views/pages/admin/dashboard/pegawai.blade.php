@extends('layouts.admin')

@section('title')
Dashboard
@endsection

@section('content')
<!-- Page Content --> 
<div class="col-md-9 ml-sm-auto col-lg-10 px-md-4 bg-light">
    <div class="container mt-3">
        <h4>Dashboard</h4>

        <div class="row">
            <div class="col-lg-4">
                <a href="/admin/transactions">
                    <div class="card dashboard-card bg-primary">
                        <div class="card-body">
                            <div class="dashboard-card-title">Pre Order Sedang Dikerjakan</div>
                            <div class="dashboard-card-subtitle">{{$transactions}}</div>
                        </div>
                    </div> 
                </a>
            </div>

            <div class="col-lg-4">
                <a href="/admin/confirmations">
                    <div class="card dashboard-card bg-success">
                        <div class="card-body">
                            <div class="dashboard-card-title">Pesanan Siap Kirim</div>
                            <div class="dashboard-card-subtitle">{{$shipping}}</div>
                        </div>
                    </div> 
                </a>
            </div>

            <div class="col-lg-4">
                <a href="/admin/complains">
                    <div class="card dashboard-card bg-danger">
                        <div class="card-body">
                            <div class="dashboard-card-title">Komplain Siap Kirim</div>
                            <div class="dashboard-card-subtitle">{{$complain_shipping}}</div>
                        </div>
                    </div> 
                </a>
            </div>
        </div>
    </div>
</div>
@endsection