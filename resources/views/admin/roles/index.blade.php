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
                        <table class="display" id="role_datatable">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Name</th>
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
                    <h4 class="text-white mb-0">Add Role</h4>
                </div>
                <div class="card-body">
                    <form id="roleForm">
                        @csrf

                        <!-- Name -->
                        <div class="form-group">
                            <label class="form-label" for="name">Name</label>
                            <input class="form-control" type="text" name="name" id="name" placeholder="Enter name" required>
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


<!-- Modal for Editing Role -->
<div class="modal fade" id="editRoleModal" tabindex="-1" aria-labelledby="editRoleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editRoleModalLabel">Edit Role</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editRoleForm">
                    @csrf
                    @method('PUT')
                    <input type="hidden" id="roleId" name="roleId">
                    <!-- Name -->
                    <div class="form-group">
                        <label for="editRoleName">Role Name</label>
                        <input type="text" class="form-control" id="editRoleName" name="name" required>
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
        var table = $("#role_datatable").DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('roles.dataTable') }}",
            columns: [
                { data: 'id', name: 'id' },
                { data: 'name', name: 'name' },
                { data: 'action', name: 'action' },
            ],
            order: [[0, 'desc']]
        });

        // Handle form submission via AJAX with SweetAlert
        $('#roleForm').on('submit', function(e) {
            e.preventDefault(); // Prevent form from refreshing the page
            let formData = $(this).serialize(); // Get form data
            
            $.ajax({
                url: "{{ route('roles.store') }}", // Route to store the role
                type: 'POST',
                data: formData,
                success: function(response) {
                    // Clear the form fields after successful submission
                    $('#name').val('');
                    
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

        $(document).on('click', '#editRole', function (e) {
            e.preventDefault();
            var roleId = $(this).data('id');
            
            // Fetch role data and populate modal
            $.ajax({
                url: '/admin/roles/' + roleId + '/edit',
                type: 'GET',
                success: function (response) {
                    if (response.success) {
                        var role = response.data;
                        $('#roleId').val(role.id);
                        $('#editRoleName').val(role.name);
                        $('#editRoleModal').modal('show');
                    } else {
                        // Handle error message
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Failed to load role details!'
                        });
                    }
                },
                error: function (xhr) {
                    // Handle AJAX errors
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'An error occurred while fetching role details!'
                    });
                }
            });
        });
    
        $('#editRoleForm').on('submit', function (e) {
            e.preventDefault();
            
            var roleId = $('#roleId').val();
            
            $.ajax({
                url: '/admin/roles/' + roleId,
                type: 'PUT',
                data: $(this).serialize(),
                success: function (response) {
                    $('#editRoleModal').modal('hide');
                    Swal.fire(
                        'Updated!',
                        'Role has been updated successfully.',
                        'success'
                    );
                    // Reload the DataTable
                    $('#role_datatable').DataTable().ajax.reload();
                },
                error: function (response) {
                    Swal.fire(
                        'Error!',
                        'There was an error updating the role.',
                        'error'
                    );
                }
            });
        });

        $(document).on('click', '#deleteRole', function (e) {
            e.preventDefault();
            var roleId = $(this).data('id');

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
                        url: '/admin/roles/' + roleId,
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
                                'There was an error deleting the role. Please try again.',
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
