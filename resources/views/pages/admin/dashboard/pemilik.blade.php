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
                            <div class="dashboard-card-title">Pre Order</div>
                            <div class="dashboard-card-subtitle">{{$pre_orders}}</div>
                        </div>
                    </div> 
                </a>
            </div>

            <div class="col-lg-4">
                <a href="/admin/confirmations">
                    <div class="card dashboard-card bg-info">
                        <div class="card-body">
                            <div class="dashboard-card-title">Pembayaran</div>
                            <div class="dashboard-card-subtitle">{{$payments}}</div>
                        </div>
                    </div> 
                </a>
            </div>

            <div class="col-lg-4">
                <a href="/admin/complains">
                    <div class="card dashboard-card bg-danger">
                        <div class="card-body">
                            <div class="dashboard-card-title">Komplain</div>
                            <div class="dashboard-card-subtitle">{{$complains}}</div>
                        </div>
                    </div> 
                </a>
            </div>

            <div class="col-lg-4">
                <a href="/admin/confirmations">
                    <div class="card dashboard-card bg-success">
                        <div class="card-body">
                            <div class="dashboard-card-title">Pendapatan</div>
                            <div class="dashboard-card-subtitle incomes">@currency($incomes)</div>
                        </div>
                    </div> 
                </a>
            </div>
        </div>
    </div>
</div>
@endsection