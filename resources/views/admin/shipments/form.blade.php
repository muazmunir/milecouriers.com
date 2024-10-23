@extends('layouts.admin')
@section('title', $pageTitle)
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-6">
             <div class="card">
                <div class="card-header">
                    <div class="card-title">
                        <h4>Sender Information</h4>
                    </div>
                </div>
                <div class="card-body">
                    <div class="card-wrapper border rounded-3">
                        <div class="row g-3">
                            <div class="col-md-12">
                                <label for="" class="form-label">Sender/Customer</label>
                                <select name="" id="" class="form-select select2">
                                    <option value="">Search Sender</option>
                                </select>
                            </div>
                            <div class="col-md-12">
                                <label for="" class="form-label">Sender/Customer Address</label>
                                <input type="text" class="form-control">
                            </div>                            
                        </div>
                    </div>
                </div>
             </div>
        </div>
        <div class="col-md-6">
             <div class="card">
                <div class="card-header">
                    <div class="card-title">
                        <h4>Recipient Information</h4>
                    </div>
                </div>
                <div class="card-body">
                    <div class="card-wrapper border rounded-3">
                        <div class="row g-3">
                            <div class="col-md-12">
                                <label for="" class="form-label">Recipient/Client</label>
                                <select name="" id="" class="form-select select2">
                                    <option value="">Search Recipient</option>
                                </select>
                            </div>
                            <div class="col-md-12">
                                <label for="" class="form-label">Recipient/Client Address</label>
                                <input type="text" class="form-control">
                            </div>                            
                        </div>
                    </div>
                </div>
             </div>
        </div>
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">
                        <h4>Shipping Information:</h4>
                    </div>
                </div>
                <div class="card-body">
                    <div class="card-wrapper border rounded-3">
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label for="" class="form-label">Delivery time</label>
                                <select name="" id="" class="form-select select2">
                                    @foreach($delivery_times as $delivery_time)
                                        <option value="{{ $delivery_time->id }}">{{ $delivery_time->delivery_time }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="" class="form-label">Payment Methods</label>
                                <select name="" id="" class="form-select select2">
                                    @foreach($payment_methods as $payment_method)
                                        <option value="{{ $payment_method->id }}">{{ $payment_method->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="" class="form-label">Delivery Status</label>
                                <select name="" id="" class="form-select select2">
                                    <option value="">Choose Sender</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="" class="form-label">Shipping mode</label>
                                <select name="" id="" class="form-select select2">
                                    @foreach($Shipping_modes as $Shipping_mode)
                                        <option value="{{ $Shipping_mode->id }}">{{ $Shipping_mode->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="" class="form-label">Type of packaging</label>
                                <select name="" id="" class="form-select select2">
                                    <option value="">Choose Sender</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="" class="form-label">Service Mode</label>
                                <select name="" id="" class="form-select select2">
                                    <option value="">Choose Sender</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="" class="form-label">Assign Driver</label>
                                <select name="" id="" class="form-select select2">
                                    <option value="">Choose Sender</option>
                                </select>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {


        
    });
</script>
@endpush
