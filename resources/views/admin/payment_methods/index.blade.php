@extends('layouts.admin')

@section('title', $pageTitle)

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-8">
            <div class="card">
                <div class="card-header bg-primary pt-2 pb-2 align-items-center">
                    <h4 class="text-white mb-0">{{ $pageTitle }}</h4>
                </div>
                <div class="card-body">
                    @if (session('success') || session('message'))
                        <div class="alert alert-{{ session('alert-type', 'success') }} alert-dismissible fade show" role="alert">
                            {{ session('success') ?? session('message') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    <div class="table-responsive custom-scrollbar">
                        <table class="display" id="payment_method_datatable">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Payment Method</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="card">
                <div class="card-header bg-primary pt-2 pb-2 align-items-center">
                    <h4 class="text-white mb-0">Add Payment Method</h4>
                </div>
                <div class="card-body">
                    <form id="paymentMethodForm">
                        @csrf

                        <!-- Payment Method -->
                        <div class="form-group">
                            <label class="form-label" for="payment_method">Payment Method</label>
                            <input class="form-control" type="text" name="name" id="payment_method" placeholder="Enter payment method" required>
                        </div>

                        <!-- Submit Button -->
                        <div class="form-group mt-3">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal for Editing Payment Method -->
<div class="modal fade" id="editPaymentMethodModal" tabindex="-1" aria-labelledby="editPaymentMethodModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editPaymentMethodModalLabel">Edit Payment Method</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editPaymentMethodForm">
                    @csrf
                    @method('PUT')
                    <input type="hidden" id="paymentMethodId" name="paymentMethodId">
                    <!-- Payment Method -->
                    <div class="form-group">
                        <label for="editPaymentMethod">Payment Method</label>
                        <input type="text" class="form-control" id="edit_payment_method" name="name" required>
                    </div>
                    <!-- Submit Button -->
                    <div class="form-group mt-3">
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<!-- Include SweetAlert -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    $(document).ready(function () {
        // Initialize DataTable
        var table = $("#payment_method_datatable").DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('payment-methods.dataTable') }}", // Adjust the route as necessary
            columns: [
                { data: 'id', name: 'id' },
                { data: 'name', name: 'name' },
                { data: 'action', name: 'action' },
            ],
        });

        // Handle form submission via AJAX with SweetAlert
        $('#paymentMethodForm').on('submit', function(e) {
            e.preventDefault(); // Prevent form from refreshing the page
            let formData = $(this).serialize(); // Get form data
            
            $.ajax({
                url: "{{ route('payment-methods.store') }}", // Route to store the payment method
                type: 'POST',
                data: formData,
                success: function(response) {
                    // Clear the form fields after successful submission
                    $('#payment_method').val('');
                    
                    // Show success message using SweetAlert
                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        text: response.message,
                        timer: 1500,
                        showConfirmButton: false
                    });

                    // Reload the DataTable
                    table.ajax.reload(null, false);
                },
                error: function(xhr) {
                    // Handle validation errors
                    if (xhr.status === 422) {
                        let errors = xhr.responseJSON.errors;
                        let errorMessage = '';
                        $.each(errors, function(key, value) {
                            errorMessage += value[0] + '\n'; // Collect all error messages
                        });

                        // Show error messages using SweetAlert
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: errorMessage
                        });
                    } else {
                        // Handle other errors using SweetAlert
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: 'Something went wrong. Please try again.'
                        });
                    }
                }
            });
        });

        // Edit Payment Method
        $(document).on('click', '#editPaymentMethod', function (e) {
            e.preventDefault();
            var paymentMethodId = $(this).data('id');
            
            // Fetch payment method data and populate modal
            $.ajax({
                url: '/admin/payment-methods/' + paymentMethodId + '/edit',
                type: 'GET',
                success: function (response) {
                    if (response.success) {
                        var paymentMethod = response.data;
                        $('#paymentMethodId').val(paymentMethod.id);
                        $('#edit_payment_method').val(paymentMethod.name);
                        $('#editPaymentMethodModal').modal('show');
                    } else {
                        // Handle error message
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Failed to load payment method details!'
                        });
                    }
                },
                error: function (xhr) {
                    // Handle AJAX errors
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'An error occurred while fetching payment method details!'
                    });
                }
            });
        });
    
        $('#editPaymentMethodForm').on('submit', function (e) {
            e.preventDefault();
            
            var paymentMethodId = $('#paymentMethodId').val();
            
            $.ajax({
                url: '/admin/payment-methods/' + paymentMethodId,
                type: 'PUT',
                data: $(this).serialize(),
                success: function (response) {
                    $('#editPaymentMethodModal').modal('hide');
                    Swal.fire(
                        'Updated!',
                        'Payment method has been updated successfully.',
                        'success'
                    );
                    // Reload the DataTable
                    $('#payment_method_datatable').DataTable().ajax.reload();
                },
                error: function (response) {
                    Swal.fire(
                        'Error!',
                        'There was an error updating the payment method.',
                        'error'
                    );
                }
            });
        });

        // Delete Payment Method
        $(document).on('click', '#deletePaymentMethod', function (e) {
            e.preventDefault();
            var paymentMethodId = $(this).data('id');

            // Show confirmation dialog
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Perform the delete AJAX request
                    $.ajax({
                        url: '/admin/payment-methods/' + paymentMethodId,
                        type: 'DELETE',
                        data: {
                            _token: '{{ csrf_token() }}' // Include CSRF token for security
                        },
                        success: function (response) {
                            Swal.fire(
                                'Deleted!',
                                response.message,
                                'success'
                            );

                            // Reload the DataTable
                            table.ajax.reload(null, false);
                        },
                        error: function (xhr) {
                            Swal.fire(
                                'Error!',
                                'There was an error deleting the payment method. Please try again.',
                                'error'
                            );
                        }
                    });
                }
            });
        });
    });

</script>

@endpush
