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
                        <table class="display" id="shipping_mode_datatable">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Shipping Mode</th>
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
                    <h4 class="text-white mb-0">Add Shipping Mode</h4>
                </div>
                <div class="card-body">
                    <form id="shippingModeForm">
                        @csrf

                        <!-- Shipping Mode -->
                        <div class="form-group">
                            <label class="form-label" for="shipping_mode">Shipping Mode</label>
                            <input class="form-control" type="text" name="name" id="shipping_mode" placeholder="Enter shipping mode" required>
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

<!-- Modal for Editing Shipping Mode -->
<div class="modal fade" id="editShippingModeModal" tabindex="-1" aria-labelledby="editShippingModeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editShippingModeModalLabel">Edit Shipping Mode</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editShippingModeForm">
                    @csrf
                    @method('PUT')
                    <input type="hidden" id="shippingModeId" name="shippingModeId">
                    <!-- Shipping Mode -->
                    <div class="form-group">
                        <label for="editShippingMode">Shipping Mode</label>
                        <input type="text" class="form-control" id="edit_shipping_mode" name="name" required>
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
        var table = $("#shipping_mode_datatable").DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('shipping-modes.dataTable') }}", // Adjust the route as necessary
            columns: [
                { data: 'id', name: 'id' },
                { data: 'name', name: 'name' },
                { data: 'action', name: 'action' },
            ],
        });

        // Handle form submission via AJAX with SweetAlert
        $('#shippingModeForm').on('submit', function(e) {
            e.preventDefault(); // Prevent form from refreshing the page
            let formData = $(this).serialize(); // Get form data
            
            $.ajax({
                url: "{{ route('shipping-modes.store') }}", // Route to store the shipping mode
                type: 'POST',
                data: formData,
                success: function(response) {
                    // Clear the form fields after successful submission
                    $('#shipping_mode').val('');
                    
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

        // Edit Shipping Mode
        $(document).on('click', '#editShippingMode', function (e) {
            e.preventDefault();
            var shippingModeId = $(this).data('id');
            
            // Fetch shipping mode data and populate modal
            $.ajax({
                url: '/admin/shipping-modes/' + shippingModeId + '/edit',
                type: 'GET',
                success: function (response) {
                    if (response.success) {
                        var shippingMode = response.data;
                        $('#shippingModeId').val(shippingMode.id);
                        $('#edit_shipping_mode').val(shippingMode.name);
                        $('#editShippingModeModal').modal('show');
                    } else {
                        // Handle error message
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Failed to load shipping mode details!'
                        });
                    }
                },
                error: function (xhr) {
                    // Handle AJAX errors
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'An error occurred while fetching shipping mode details!'
                    });
                }
            });
        });
    
        $('#editShippingModeForm').on('submit', function (e) {
            e.preventDefault();
            
            var shippingModeId = $('#shippingModeId').val();
            
            $.ajax({
                url: '/admin/shipping-modes/' + shippingModeId,
                type: 'PUT',
                data: $(this).serialize(),
                success: function (response) {
                    $('#editShippingModeModal').modal('hide');
                    Swal.fire(
                        'Updated!',
                        'Shipping mode has been updated successfully.',
                        'success'
                    );
                    // Reload the DataTable
                    $('#shipping_mode_datatable').DataTable().ajax.reload();
                },
                error: function (response) {
                    Swal.fire(
                        'Error!',
                        'There was an error updating the shipping mode.',
                        'error'
                    );
                }
            });
        });

        // Delete Shipping Mode
        $(document).on('click', '#deleteShippingMode', function (e) {
            e.preventDefault();
            var shippingModeId = $(this).data('id');

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
                        url: '/admin/shipping-modes/' + shippingModeId,
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
                                'There was an error deleting the shipping mode. Please try again.',
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
