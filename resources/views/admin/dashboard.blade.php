@extends('admin.layouts.app')
@section('content')
    <div class="container-fluid p-4">
        <div class="row g-3">
            <div class="col-lg-3 col-md-6">
                <div class="card text-center card-gradient-primary">
                    <div class="card-body">
                        <i class="bi bi-people card-icon"></i>
                        <h5 class="card-title">Users</h5>
                        <p class="card-text">1,234</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="card text-center card-gradient-success">
                    <div class="card-body">
                        <i class="bi bi-boxes card-icon"></i>
                        <h5 class="card-title">Products</h5>
                        <p class="card-text">1,234</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="card text-center card-gradient-warning">
                    <div class="card-body">
                        <i class="bi bi-cart-check card-icon"></i>
                        <h5 class="card-title">Orders</h5>
                        <p class="card-text">1,234</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="card text-center card-gradient-danger">
                    <div class="card-body">
                        <i class="bi bi-cash-coin card-icon"></i>
                        <h5 class="card-title">Revenue</h5>
                        <p class="card-text">$12,345</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection