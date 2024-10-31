@extends('layouts.admin')
@section('title', $pageTitle)
@section('content')
<div class="container-fluid">
    <form action="{{ isset($shipment) ? route('shipments.update', $shipment->id) : route('shipments.store') }}" method="POST">
    @csrf
    @if(isset($shipment))
            @method('PUT')
        @endif
        <div class="row">
                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        @foreach ($errors->all() as $error)
                            <p>{{ $error }}</p>
                        @endforeach
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="" class="form-label">Delivery Status</label>
                                <select name="status_id" class="form-select select2">
                                    @foreach($delivery_statuses as $delivery_status)
                                        <option value="{{ $delivery_status->id }}">{{ $delivery_status->name }}</option>
                                    @endforeach
                                </select>

                            </div>
                            <div class="col-md-6">
                                <label for="" class="form-label">Tracking Number</label>
                                <input type="text" name="shipment_number" id="shipment_number" class="form-control" value="{{ old('shipment_number', $shipment->shipment_number ?? '') }}" required>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                 <div class="card">
                    <div class="card-header bg-primary pt-2 pb-2 align-items-center d-flex justify-content-between">
                        <h4 class="text-white mb-0">Sender Information</h4>
                        <!-- Refresh Button -->
                        <button id="refreshUsers" type="button" class="text-white btn border border-white">Refresh</button>
                    </div>
                    <div class="card-body">
                        <div class="card-wrapper border rounded-3">
                            <div class="row g-3">
                                <div class="col-md-12">
                                    <label for="senderSelect" class="form-label">Sender/Customer</label>
                                    <a href="{{ route('users.create') }}" target="_blank" class="btn btn-primary float-end">Add New</a>
                                    <select name="sender_id" id="senderSelect" class="form-select select2">
                                    </select>
                                </div>
                                <div class="col-md-12">
                                    <label for="" class="form-label">Sender/Customer Address</label>
                                    <input type="text" name="origin_address" id="sender-address" class="form-control" required>
                                </div>                            
                            </div>
                        </div>
                    </div>
                 </div>
            </div>
            <div class="col-md-6">
                 <div class="card">
                    <div class="card-header bg-primary pt-2 pb-2 align-items-center d-flex justify-content-between">
                        <h4 class="text-white mb-0">Recipient Information</h4>
                        <!-- Refresh Button -->
                        <button id="refreshRecipient" type="button" class="text-white btn border border-white">Refresh</button>
                    </div>
                    <div class="card-body">
                        <div class="card-wrapper border rounded-3">
                            <div class="row g-3">
                                <div class="col-md-12">
                                    <label for="" class="form-label">Recipient/Client</label>
                                    <a href="{{ route('users.create') }}" target="_blank" class="btn btn-primary float-end">Add New</a>
                                    <select name="recipient_id" id="recipientSelect" class="form-select select2">
                                    </select>
                                </div>
                                <div class="col-md-12">
                                    <label for="" class="form-label">Recipient/Client Address</label>
                                    <input type="text" name="destination_address" id="recipient-address" class="form-control">
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
                                    <select name="delivery_time_id" class="form-select select2">
                                        @foreach($delivery_times as $delivery_time)
                                            <option value="{{ $delivery_time->id }}" <?php if(isset($shipment) && $shipment->delivery_time_id == $delivery_time->id) { echo 'selected'; } ?> >{{ $delivery_time->delivery_time }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label for="" class="form-label">Payment Methods</label>
                                    <select name="payment_method_id" class="form-select select2">
                                        @foreach($payment_methods as $payment_method)
                                            <option value="{{ $payment_method->id }}" <?php if(isset($shipment) && $shipment->payment_method_id == $payment_method->id) { echo 'selected'; } ?> >{{ $payment_method->name }}</option>
                                        @endforeach
                                    </select>
                                </div>                                
                                <div class="col-md-4">
                                    <label for="" class="form-label">Shipping mode</label>
                                    <select name="shipping_mode_id" class="form-select select2">
                                        @foreach($shipping_modes as $Shipping_mode)
                                            <option value="{{ $Shipping_mode->id }}" <?php if(isset($shipment) && $shipment->shipping_mode_id == $Shipping_mode->id) { echo 'selected'; } ?> >{{ $Shipping_mode->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                
                                <div class="col-md-4">
                                    <label for="" class="form-label">Service Mode</label>
                                    <select name="service_mode_id" class="form-select select2">
                                        @foreach($service_modes as $service_mode)
                                            <option value="{{ $service_mode->id }}" <?php if(isset($shipment) && $shipment->service_mode_id == $service_mode->id) { echo 'selected'; } ?> >{{ $service_mode->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label for="" class="form-label">Assign Driver</label>
                                    <select name="driver_id" class="form-select select2">
                                        @foreach($drivers as $driver)
                                            <option value="{{ $driver->id }}" <?php if(isset($shipment) && $shipment->driver_id == $driver->id) { echo 'selected'; } ?> >{{ $driver->first_name }} {{ $driver->last_name }}</option>
                                        @endforeach
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
                                <div class="row align-items-center">
                                    <!-- Description Field -->
                                    <div class="col-sm-12 col-md-6 col-lg-3">
                                        <label for="description" class="form-label">Description</label>
                                        <div class="touchspin-wrapper"> 
                                            <textarea name="description[]" rows="1" class="form-control" placeholder="Package Description"></textarea>
                                        </div>
                                    </div>
                                    
                                    <!-- Package Type Field -->
                                    <div class="col-sm-12 col-md-6 col-lg-3">
                                        <label for="type_of_packaging" class="form-label">Package Type</label>
                                        <div class="touchspin-wrapper"> 
                                            <select name="type_of_packaging[]" class="form-select">
                                                @foreach($type_of_packagings as $type_of_packaging)
                                                    <option value="{{ $type_of_packaging->id }}">{{ $type_of_packaging->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    
                                    <!-- Quantity Field -->
                                    <div class="col-sm-12 col-md-6 col-lg-2">
                                        <label class="form-label">Quantity</label>
                                        <div class="touchspin-wrapper"> 
                                            <button class="decrement-touchspin btn-touchspin spin-border-primary" type="button">
                                                <i class="fa fa-minus"></i>
                                            </button>
                                            <input name="quantity[]" class="input-touchspin spin-outline-primary" type="number">
                                            <button class="increment-touchspin btn-touchspin spin-border-primary" type="button">
                                                <i class="fa fa-plus"></i>
                                            </button>
                                        </div>                                        
                                    </div>
                                    
                                    <!-- Weight Field -->
                                    <div class="col-sm-12 col-md-6 col-lg-2">
                                        <label class="form-label">Weight</label>
                                        <div class="touchspin-wrapper"> 
                                            <button class="decrement-touchspin btn-touchspin spin-border-primary" type="button">
                                                <i class="fa fa-minus"></i>
                                            </button>
                                            <input name="weight[]" class="input-touchspin spin-outline-primary" type="number">
                                            <button class="increment-touchspin btn-touchspin spin-border-primary" type="button">
                                                <i class="fa fa-plus"></i>
                                            </button>
                                        </div>                                        
                                    </div>
                                    
                                    <!-- Remove Button -->
                                    <div class="col-sm-12 col-md-6 col-lg-2 d-flex align-items-center justify-content-center">
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
            <div class="col-md-12 text-end">
                <button type="submit" class="btn btn-primary">Save</button>
            </div>
        </div>
    </form>
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
                senderSelect.append('<option value="">Select Sender</option>');
                
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
            url: '/admin/fetch-recipient/' + excludedSenderId,
            type: 'GET',
            success: function(data) {
                let recipientSelect = $('#recipientSelect');
                recipientSelect.empty();  // Clear current options
                recipientSelect.append('<option value="">Select Recipient</option>');

                $.each(data, function(key, user) {
                    recipientSelect.append(`<option value="${user.id}" data-address="${user.address}">${user.first_name} ${user.last_name} | ${user.phone}</option>`);

                });

                let selectedRecipient = recipientSelect.val();
                if (selectedRecipient) {
                    fetchRecipientAddress(selectedRecipient);
                }
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

    function fetchRecipientAddress(recipientId) {
        $.ajax({
            url: `/admin/fetch-user-address/${recipientId}`,
            type: 'GET',
            success: function(data) {
                $('#recipient-address').val(data.address);
            },
            error: function() {
                alert('Failed to fetch recipient address.');
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

    $('#refreshRecipient').click(function() {
        fetchUsers();
        Swal.fire({
            title: 'Success!',
            text: 'The Recipient list has been refreshed.',
            icon: 'success',
            confirmButtonText: 'OK'
        });
    });
    

    $('#recipientSelect').change(function() {
        let selectedReciepentId = $(this).val();  // Get selected sender ID
        let selectedAddress = $(this).find(':selected').data('address');  // Get address from selected option

        $('#recipient-address').val(selectedAddress);  // Set the address in the input field

    });


    $('#senderSelect').change(function() {
        let selectedSenderId = $(this).val();  // Get selected sender ID
        let selectedAddress = $(this).find(':selected').data('address');  // Get address from selected option

        $('#sender-address').val(selectedAddress);  // Set the address in the input field

        // Fetch recipients excluding the selected sender ID
        fetchRecipients(selectedSenderId);
    });
    
    
    $('.package-item:first').find('.remove-package').hide();

    function initializeTouchspin(wrapper) {
    const inputField = wrapper.querySelector('.input-touchspin');
    const incrementButton = wrapper.querySelector('.increment-touchspin');
    const decrementButton = wrapper.querySelector('.decrement-touchspin');

    // Ensure all elements are present before proceeding
    if (!inputField || !incrementButton || !decrementButton) {
        console.warn("Touchspin elements not found in wrapper:", wrapper);
        return; // Skip this iteration if any element is missing
    }

    // Set the initial value and define step based on input name
    let step;
    if (inputField.name === 'quantity[]') {
        inputField.value = parseInt(inputField.value) || 1; // Start at 1 for quantity
        step = 1;
    } else if (inputField.name === 'weight[]') {
        inputField.value = parseFloat(inputField.value) || 0.5; // Start at 0.5 for weight
        step = 0.5;
    } else {
        console.warn("Unrecognized input name:", inputField.name);
        return; // Skip if the input name does not match expected values
    }

    // Increment button functionality
    incrementButton.addEventListener('click', () => {
        let currentValue = parseFloat(inputField.value) || 0;
        currentValue += step;
        inputField.value = currentValue.toFixed(step === 0.5 ? 1 : 0); // Use 1 decimal for weight
    });

    // Decrement button functionality
    decrementButton.addEventListener('click', () => {
        let currentValue = parseFloat(inputField.value) || 0;
        if (currentValue > step) {
            currentValue -= step;
            inputField.value = currentValue.toFixed(step === 0.5 ? 1 : 0); // Use 1 decimal for weight
        }
    });
}

    function scrollToBottom() {
        $('html, body').animate({ scrollTop: $(document).height() }, 'slow');
    }
    // Function to add a new package
    $('#addPackage').click(function() {
        var packageClone = $('.package-item:first').clone();  // Clone the first package item
        packageClone.find('input, textarea').val('');  // Clear the values in the cloned section
        packageClone.find('.remove-package').show();   // Ensure remove button is visible for the cloned item

        $('#packageContainer').append(packageClone);  // Add the cloned section to the container
        packageClone.find('.touchspin-wrapper').each(function() {
            initializeTouchspin(this);
        });
        scrollToBottom();
    });

    $('.package-item .touchspin-wrapper').each(function() {
    initializeTouchspin(this);
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
