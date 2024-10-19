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
                        <table class="display" id="packing_type_datatable">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Packing Type</th>
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
                    <h4 class="text-white mb-0">Add Packing Type</h4>
                </div>
                <div class="card-body">
                    <form id="packingTypeForm">
                        @csrf

                        <!-- Packing Type -->
                        <div class="form-group">
                            <label class="form-label" for="packing_type">Packing Type</label>
                            <input class="form-control" type="text" name="name" id="packing_type" placeholder="Enter packing type" required>
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

<!-- Modal for Editing Packing Type -->
<div class="modal fade" id="editPackingTypeModal" tabindex="-1" aria-labelledby="editPackingTypeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editPackingTypeModalLabel">Edit Packing Type</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editPackingTypeForm">
                    @csrf
                    @method('PUT')
                    <input type="hidden" id="packingTypeId" name="packingTypeId">
                    <!-- Packing Type -->
                    <div class="form-group">
                        <label for="editPackingType">Packing Type</label>
                        <input type="text" class="form-control" id="edit_packing_type" name="name" required>
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
        var table = $("#packing_type_datatable").DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('types-of-packings.dataTable') }}", // Adjust the route as necessary
            columns: [
                { data: 'id', name: 'id' },
                { data: 'name', name: 'name' },
                { data: 'action', name: 'action' },
            ],
        });

        // Handle form submission via AJAX with SweetAlert
        $('#packingTypeForm').on('submit', function(e) {
            e.preventDefault(); // Prevent form from refreshing the page
            let formData = $(this).serialize(); // Get form data
            
            $.ajax({
                url: "{{ route('types-of-packings.store') }}", // Route to store the packing type
                type: 'POST',
                data: formData,
                success: function(response) {
                    // Clear the form fields after successful submission
                    $('#packing_type').val('');
                    
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

        // Edit Packing Type
        $(document).on('click', '#editPackingType', function (e) {
            e.preventDefault();
            var packingTypeId = $(this).data('id');
            
            // Fetch packing type data and populate modal
            $.ajax({
                url: '/admin/types-of-packings/' + packingTypeId + '/edit',
                type: 'GET',
                success: function (response) {
                    if (response.success) {
                        var packingType = response.data;
                        $('#packingTypeId').val(packingType.id);
                        $('#edit_packing_type').val(packingType.name);
                        $('#editPackingTypeModal').modal('show');
                    } else {
                        // Handle error message
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Failed to load packing type details!'
                        });
                    }
                },
                error: function (xhr) {
                    // Handle AJAX errors
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'An error occurred while fetching packing type details!'
                    });
                }
            });
        });
    
        $('#editPackingTypeForm').on('submit', function (e) {
            e.preventDefault();
            
            var packingTypeId = $('#packingTypeId').val();
            
            $.ajax({
                url: '/admin/types-of-packings/' + packingTypeId,
                type: 'PUT',
                data: $(this).serialize(),
                success: function (response) {
                    $('#editPackingTypeModal').modal('hide');
                    Swal.fire(
                        'Updated!',
                        'Packing type has been updated successfully.',
                        'success'
                    );
                    // Reload the DataTable
                    $('#packing_type_datatable').DataTable().ajax.reload();
                },
                error: function (response) {
                    Swal.fire(
                        'Error!',
                        'There was an error updating the packing type.',
                        'error'
                    );
                }
            });
        });

        // Delete Packing Type
        $(document).on('click', '#deletePackingType', function (e) {
            e.preventDefault();
            var packingTypeId = $(this).data('id');

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
                        url: '/admin/types-of-packings/' + packingTypeId,
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
                                'There was an error deleting the packing type. Please try again.',
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
