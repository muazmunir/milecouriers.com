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
                        <table class="display" id="delivery_time_datatable">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Delivery Time</th>
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
                    <h4 class="text-white mb-0">Add Delivery Time</h4>
                </div>
                <div class="card-body">
                    <form id="deliveryTimeForm">
                        @csrf

                        <!-- Delivery Time -->
                        <div class="form-group">
                            <label class="form-label" for="delivery_time">Delivery Time</label>
                            <input class="form-control" type="text" name="delivery_time" id="delivery_time" placeholder="Enter delivery time" required>
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

<!-- Modal for Editing Delivery Time -->
<div class="modal fade" id="editDeliveryTimeModal" tabindex="-1" aria-labelledby="editDeliveryTimeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editDeliveryTimeModalLabel">Edit Delivery Time</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editDeliveryTimeForm">
                    @csrf
                    @method('PUT')
                    <input type="hidden" id="deliveryTimeId" name="deliveryTimeId">
                    <!-- Delivery Time -->
                    <div class="form-group">
                        <label for="editDeliveryTime">Delivery Time</label>
                        <input type="text" class="form-control" id="editDeliveryTime" name="delivery_time" required>
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
        var table = $("#delivery_time_datatable").DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('delivery-times.dataTable') }}", // Adjust the route as necessary
            columns: [
                { data: 'id', name: 'id' },
                { data: 'delivery_time', name: 'delivery_time' },
                { data: 'action', name: 'action' },
            ],
            order: [[0, 'desc']]
        });

        // Handle form submission via AJAX with SweetAlert
        $('#deliveryTimeForm').on('submit', function(e) {
            e.preventDefault(); // Prevent form from refreshing the page
            let formData = $(this).serialize(); // Get form data
            
            $.ajax({
                url: "{{ route('delivery-times.store') }}", // Route to store the delivery time
                type: 'POST',
                data: formData,
                success: function(response) {
                    // Clear the form fields after successful submission
                    $('#delivery_time').val('');
                    
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

        $(document).on('click', '#editDeliveryTime', function (e) {
            e.preventDefault();
            var deliveryTimeId = $(this).data('id');
            
            // Fetch delivery time data and populate modal
            $.ajax({
                url: '/admin/delivery-times/' + deliveryTimeId + '/edit',
                type: 'GET',
                success: function (response) {
                    if (response.success) {
                        var deliveryTime = response.data;
                        $('#deliveryTimeId').val(deliveryTime.id);
                        $('#editDeliveryTime').val(deliveryTime.delivery_time);
                        $('#editDeliveryTimeModal').modal('show');
                    } else {
                        // Handle error message
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Failed to load delivery time details!'
                        });
                    }
                },
                error: function (xhr) {
                    // Handle AJAX errors
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'An error occurred while fetching delivery time details!'
                    });
                }
            });
        });
    
        $('#editDeliveryTimeForm').on('submit', function (e) {
            e.preventDefault();
            
            var deliveryTimeId = $('#deliveryTimeId').val();
            
            $.ajax({
                url: '/admin/delivery-times/' + deliveryTimeId,
                type: 'PUT',
                data: $(this).serialize(),
                success: function (response) {
                    $('#editDeliveryTimeModal').modal('hide');
                    Swal.fire(
                        'Updated!',
                        'Delivery time has been updated successfully.',
                        'success'
                    );
                    // Reload the DataTable
                    $('#delivery_time_datatable').DataTable().ajax.reload();
                },
                error: function (response) {
                    Swal.fire(
                        'Error!',
                        'There was an error updating the delivery time.',
                        'error'
                    );
                }
            });
        });

        $(document).on('click', '#deleteDeliveryTime', function (e) {
            e.preventDefault();
            var deliveryTimeId = $(this).data('id');

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
                        url: '/admin/delivery-times/' + deliveryTimeId,
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
                                'There was an error deleting the delivery time. Please try again.',
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
