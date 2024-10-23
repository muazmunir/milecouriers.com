@extends('layouts.admin')

@section('title', $pageTitle)

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header bg-primary pt-2 pb-2 d-flex justify-content-between align-items-center">
                    <h4 class="text-white mb-0">{{ $pageTitle }}</h4>
                    <a href="{{ route('users.create') }}" class="text-white"><i class="icofont icofont-ui-add"></i> Add New</a>
                </div>
                <div class="card-body">
                    @if (session('success') || session('message'))
                        <div class="alert alert-{{ session('alert-type', 'success') }} alert-dismissible fade show" role="alert">
                            {{ session('success') ?? session('message') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    <div class="table-responsive custom-scrollbar">
                        <table class="display" id="user_datatable">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function () {
        var table = $("#user_datatable").DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('users.dataTable') }}",
            columns: [
                { data: 'id', name: 'id' },
                { data: 'name', name: 'name' },
                { data: 'email', name: 'email' },
                { data: 'type', name: 'type' },
                { data: 'action', name: 'action' },
            ],
            order: [[0, 'desc']]
        });
        
        $(document).on('click', '#deleteUser', function(event) {
            event.preventDefault();
            var userId = $(this).data('id'); // Get the user ID

            swal({
                title: "Are you sure?",
                text: "This action cannot be undone!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    $.ajax({
                        url: '/admin/users/' + userId, // Updated route to match your DELETE route
                        method: 'DELETE',
                        data: {
                            _token: $('meta[name="csrf-token"]').attr('content') // CSRF token
                        },
                        success: function(response) {
                            swal(response.message, {
                                icon: response.status,
                            });
                            table.ajax.reload();
                        },
                        error: function(xhr) {
                            swal("Error deleting user!", {
                                icon: "error",
                            });
                        }
                    });
                }
            });
        });
    });
</script>

@endpush