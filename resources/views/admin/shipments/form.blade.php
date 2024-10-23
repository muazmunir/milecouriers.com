@extends('layouts.admin')
@section('title', $pageTitle)
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-6">
             <div class="card">
                <div class="card-header bg-primary pt-2 pb-2 align-items-center">
                    <h4 class="text-white mb-0">Sender Information</h4>
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
                <div class="card-header bg-primary pt-2 pb-2 align-items-center">
                    <h4 class="text-white mb-0">Recipient Information</h4>
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
                <div class="card-header bg-primary pt-2 pb-2 align-items-center">
                    <h4 class="text-white mb-0">Shipping Information</h4>
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
                                    <option value="">Choose Delivery Status</option>
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
                                <label for="" class="form-label">Service Mode</label>
                                <select name="" id="" class="form-select select2">
                                    <option value="">Choose Service Mode</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="" class="form-label">Assign Driver</label>
                                <select name="" id="" class="form-select select2">
                                    <option value="">Choose Driver</option>
                                </select>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-primary pt-2 pb-2 d-flex justify-content-between align-items-center">
                    <h4 class="text-white mb-0">Package Information</h4>
                </div>

                <div class="card-body">
                    <div id="packageContainer">
                        <div class="card-wrapper border rounded-3 border-primary package-item mb-3">
                            <div class="row g-3">
                                <div class="col-md-2">
                                    <label for="weight" class="form-label">Package Weight (kg)</label>
                                    <input type="number" step="0.01" class="form-control" name="weight[]" required>
                                </div>
                                <div class="col-md-2">
                                    <label for="length" class="form-label">Length (cm)</label>
                                    <input type="number" step="0.01" class="form-control" name="length[]" required>
                                </div>
                                <div class="col-md-2">
                                    <label for="width" class="form-label">Width (cm)</label>
                                    <input type="number" step="0.01" class="form-control" name="width[]" required>
                                </div>
                                <div class="col-md-2">
                                    <label for="height" class="form-label">Height (cm)</label>
                                    <input type="number" step="0.01" class="form-control" name="height[]" required>
                                </div>
                                <div class="col-md-2">
                                    <label for="declared_value" class="form-label">Declared Value ($)</label>
                                    <input type="number" step="0.01" class="form-control" name="declared_value[]" required>
                                </div>
                                <div class="col-md-2">
                                    <label for="insurance" class="form-label">Insurance Amount</label>
                                    <input type="number" step="0.01" class="form-control" name="insurance[]">
                                </div>
                                <div class="col-md-4">
                                    <label for="" class="form-label">Type of packaging</label>
                                    <select name="" id="" class="form-select">
                                        <option value="">Choose Sender</option>
                                    </select>
                                </div>
                                <div class="col-md-8">
                                    <label for="package_contents" class="form-label">Package Contents</label>
                                    <textarea class="form-control" name="package_contents[]" rows="1" placeholder="Describe the contents of the package" required></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Move the Add Package button here -->
                    <button type="button" id="addPackage" class="btn btn-success mt-3">Add Package</button>
                </div>

            </div>
        </div>

    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // Function to add a new package
    $('#addPackage').click(function() {
        var packageClone = $('.package-item:first').clone();  // Clone the first package item
        packageClone.find('input, textarea').val('');  // Clear the values in the cloned section

        // Add the remove button to the cloned section
        packageClone.append('<div><button type="button" class="btn btn-sm btn-danger remove-package mt-3">Remove Package</button>');

        $('#packageContainer').append(packageClone);  // Add the cloned section to the container
    });

    // Function to remove a package
    $(document).on('click', '.remove-package', function() {
        if ($('.package-item').length > 1) {
            $(this).closest('.package-item').remove();  // Remove the respective package item
        } else {
            alert('At least one package is required.');
        }
    });
});

</script>
@endpush
