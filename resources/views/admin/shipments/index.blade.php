@extends('layouts.admin')

@section('title', $pageTitle)

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
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
                    <div class="row mb-4">
                        <div class="col-md-4 form-group">
                            <label for="name">Tracking #</label>
                            <input type="text" id="name" class="form-control" placeholder="Enter tracking number">
                        </div>
                        <div class="col-md-4 form-group">
                            <label for="">Start Date</label>
                            <input type="date" id="start_date" class="form-control" placeholder="Start Date">
                        </div>
                        <div class="col-md-4 form-group">
                            <label for="">End Date</label>
                            <input type="date" id="end_date" class="form-control" placeholder="End Date">
                        </div>
                        <div class="col-md-4 form-group">
                            <label for="status">Status:</label>
                            <select id="status" class="form-control select2">
                                <option value="">All</option>
                                @foreach($delivery_statuses as $delivery_status)
                                <option value="{{ $delivery_status->id }}">{{ $delivery_status->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4 form-group mt-4">
                            <button id="searchButton" class="btn btn-primary mt-2">Search</button>
                            <button id="clearFilters" class="btn btn-secondary mt-2">Clear Filters</button>
                        </div>

                    </div>
                    <div class="table-responsive custom-scrollbar">
                        <table class="display" id="service_mode_datatable">
                            <thead>
                                <tr>
                                    <th>Tracking</th>
                                    <th>Date</th>
                                    <th>Sender</th>
                                    <th>Recipient</th>
                                    <th>Origin</th>
                                    <th>Destination</th>
                                    <th>Status</th>
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
<!-- Include SweetAlert -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    $(document).ready(function () {
        // Initialize DataTable
        var table = $("#service_mode_datatable").DataTable({
            processing: true,
            serverSide: true,
            searching: false,
            ajax: "{{ route('shipments.dataTable') }}", // Adjust the route as necessary
            columns: [
                { data: 'shipment_number', name: 'shipment_number' },
                { data: 'shipment_date', name: 'shipment_date' },
                { data: 'sender', name: 'sender' },
                { data: 'recipient', name: 'recipient' },
                { data: 'origin_address', name: 'origin_address' },
                { data: 'destination_address', name: 'destination_address' },
                { data: 'status', name: 'status' },
                { data: 'action', name: 'action' },
            ],
        });
            // Delete Service Mode
        $(document).on('click', '#deleteShipment', function (e) {
            e.preventDefault();
            var serviceModeId = $(this).data('id');

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
                        url: '/admin/shipments/' + serviceModeId,
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
                                'There was an error deleting the shipment. Please try again.',
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
