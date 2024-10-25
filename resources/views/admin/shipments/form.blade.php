@extends('layouts.admin')
@section('title', $pageTitle)
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-6">
             <div class="card">
                <div class="card-header bg-primary pt-2 pb-2 align-items-center d-flex justify-content-between">
                    <h4 class="text-white mb-0">Sender Information</h4>
                    <!-- Refresh Button -->
                    <button id="refreshUsers" class="text-white btn border border-white">Refresh</button>
                </div>
                <div class="card-body">
                    <div class="card-wrapper border rounded-3">
                        <div class="row g-3">
                            <div class="col-md-12">
                                <label for="senderSelect" class="form-label">Sender/Customer</label>
                                <a href="{{ route('users.create') }}" target="_blank" class="btn btn-primary float-end">Add New</a>
                                <select name="sender_id" id="senderSelect" class="form-select select2">
                                    <option value="" selected disabled>Select Sender</option>
                                </select>
                            </div>
                            <div class="col-md-12">
                                <label for="" class="form-label">Sender/Customer Address</label>
                                <input type="text" id="sender-address" class="form-control">
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
                                <select name="" id="recipientSelect" class="form-select select2">
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
                                    @foreach($delivery_statuses as $delivery_status)
                                        <option value="{{ $delivery_status->id }}">{{ $delivery_status->name }}</option>
                                    @endforeach
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
                            <div class="row align-items-center"> <!-- Added 'align-items-center' for vertical alignment -->
                                <div class="col-sm-12 col-md-6 col-lg-3">
                                    <div class="form-group">
                                        <label for="description">Package Description</label>
                                        <div class="input-group">
                                            <textarea name="description[]" rows="1" class="form-control"  placeholder="Package Description"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-6 col-lg-3">
                                    <div class="form-group">
                                        <label for="shipping_mode_0">Type of packing</label>
                                        <select name="type_of_packaging[]" class="form-select">
                                            @foreach($type_of_packagings as $type_of_packaging)
                                                <option value="{{ $type_of_packaging->id }}">{{ $type_of_packaging->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-6 col-lg-1">
                                    <div class="form-group">
                                        <label for="weight">Weight</label>
                                        <div class="input-group">
                                            <input type="text" value="0" name="weight[]"  class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-6 col-lg-1">
                                    <div class="form-group">
                                        <label for="length">Length</label>
                                        <div class="input-group">
                                            <input type="text" value="0" name="length[]" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-6 col-lg-1">
                                    <div class="form-group">
                                        <label for="width">Width</label>
                                        <div class="input-group">
                                            <input type="text"  value="0" name="width[]" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-6 col-lg-1">
                                    <div class="form-group">
                                        <label for="height_0">Height</label>
                                        <div class="input-group">
                                            <input type="text"  value="0"  name="height" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-6 col-lg-1">
                                    <div class="form-group">
                                        <label for="declaredValue_0">DecValue</label>
                                        <div class="input-group">
                                            <input type="text"  value="0" name="declared_value[]" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-6 col-lg-1 d-flex align-items-center justify-content-center">
                                    <div class="form-group">
                                        <button type="button" class="btn btn-outline-danger remove-package" style="height: 38px;">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </div>
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
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
$(document).ready(function() {

    function fetchUsers() {
        $.ajax({
            url: '{{ route("fetch.users") }}',
            type: 'GET',
            success: function(data) {
                let senderSelect = $('#senderSelect');
                senderSelect.empty();  // Clear current options
                senderSelect.append('<option value="" disabled>Select Sender</option>');
                
                $.each(data, function(key, user) {
                    senderSelect.append(`<option value="${user.id}" data-address="${user.address}">${user.first_name} ${user.last_name} | ${user.phone}</option>`);
                });

                // If a sender is already selected, trigger the change event to load the address
                let selectedSender = senderSelect.val();
                if (selectedSender) {
                    fetchSenderAddress(selectedSender);
                }
            },
            error: function() {
                alert('Failed to fetch users. Please try again.');
            }
        });
    }

    function fetchRecipients(excludedSenderId) {
        $.ajax({
            url: '{{ route("fetch.users") }}',
            type: 'GET',
            success: function(data) {
                let recipientSelect = $('#recipientSelect');
                recipientSelect.empty();  // Clear current options
                recipientSelect.append('<option value="" disabled>Select Recipient</option>');

                $.each(data, function(key, user) {
                    recipientSelect.append(`<option value="${user.id}" data-address="${user.address}">${user.first_name} ${user.last_name} | ${user.phone}</option>`);
                });
            },
            error: function() {
                alert('Failed to fetch recipients. Please try again.');
            }
        });
    }
    // Initial fetch when page loads
    function fetchSenderAddress(senderId) {
        $.ajax({
            url: `/admin/fetch-user-address/${senderId}`,
            type: 'GET',
            success: function(data) {
                $('#sender-address').val(data.address);
                fetchRecipients(senderId);
            },
            error: function() {
                alert('Failed to fetch sender address.');
            }
        });
    }

    // Initial fetch when page loads
    fetchUsers();

    // Refresh users on button click
    $('#refreshUsers').click(function() {
        fetchUsers();
        Swal.fire({
            title: 'Success!',
            text: 'The sender list has been refreshed.',
            icon: 'success',
            confirmButtonText: 'OK'
        });
    });

    $('#senderSelect').change(function() {
        let selectedSenderId = $(this).val();  // Get selected sender ID
        let selectedAddress = $(this).find(':selected').data('address');  // Get address from selected option

        $('#sender-address').val(selectedAddress);  // Set the address in the input field

        // Fetch recipients excluding the selected sender ID
        fetchRecipients(selectedSenderId);
    });
    
    $('.package-item:first').find('.remove-package').hide();
    // Function to add a new package
    $('#addPackage').click(function() {
        var packageClone = $('.package-item:first').clone();  // Clone the first package item
        packageClone.find('input, textarea').val('');  // Clear the values in the cloned section
        packageClone.find('.remove-package').show();   // Ensure remove button is visible for the cloned item

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
