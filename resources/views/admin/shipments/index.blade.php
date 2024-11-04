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
                            <label for="shipment_number">Tracking #</label>
                            <input type="text" id="shipment_number" class="form-control" placeholder="Enter tracking number">
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
                            <label for="status_id">Status:</label>
                            <select id="status_id" class="form-control select2">
                                <option value="">All</option>
                                @foreach($delivery_statuses as $delivery_status)
                                <option value="{{ $delivery_status->id }}">{{ $delivery_status->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4 form-group">
                            <label for="driver_id">Driver:</label>
                            <select id="driver_id" class="form-control select2">
                                <option value="">All</option>
                                @foreach($drivers as $driver)
                                <option value="{{ $driver->id }}">{{ $driver->full_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4 form-group mt-4">
                            <button id="searchButton" class="btn btn-primary mt-2">Search</button>
                            <button id="clearFilters" class="btn btn-secondary mt-2">Clear Filters</button>
                            <button id="printAllButton" class="btn btn-info mt-2">Print All</button>
                        </div>

                    </div>
                    <div class="table-responsive custom-scrollbar">
                        <table class="display" id="shipments_datatable">
                            <thead>
                                <tr>
                                    <th>Tracking</th>
                                    <th>Date</th>
                                    <th>Sender</th>
                                    <!-- <th>Recipient</th> -->
                                    <!-- <th>Origin</th> -->
                                    <th>Destination</th>
                                    <th>Driver</th>
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
        var table = $("#shipments_datatable").DataTable({
            processing: true,
            serverSide: true,
            searching: false,
            ajax: {
                url: "{{ route('shipments.dataTable') }}",
                data: function (d) {
                    d.shipment_number = $('#shipment_number').val();
                    d.start_date = $('#start_date').val();
                    d.end_date = $('#end_date').val();
                    d.status_id = $('#status_id').val();
                    d.driver_id = $('#driver_id').val();
                }
            },
            columns: [
                { data: 'shipment_number', name: 'shipment_number' },
                { data: 'shipment_date', name: 'shipment_date' },
                { data: 'sender', name: 'sender' },
                // { data: 'recipient', name: 'recipient' },
                // { data: 'origin_address', name: 'origin_address' },
                { data: 'destination_address', name: 'destination_address' },
                { 
                    data: 'driver', 
                    name: 'driver',
                    render: function(data, type, row) {
                        // Render the driver select dropdown
                        var select = '<select class="driver-select-dropdown select2" data-id="' + row.id + '">';
                        select += '<option value="" disabled ' + (row.driver_id ? '' : 'selected') + '>Choose One</option>'; // Add "Choose One" option
                        <?php foreach ($drivers as $driver) { ?>
                            select += '<option value="{{ $driver->id }}" ' + (row.driver_id == "{{ $driver->id }}" ? 'selected' : '') + '>{{ $driver->full_name }}</option>';
                        <?php } ?>
                        select += '</select>';
                        return select;
                    }
        
                },
                { data: 'status', name: 'status' },
                { data: 'action', searchable: false, orderable: false },
            ],
            initComplete: function () {
                // Initialize Select2 for all driver select dropdowns
                $('.select2').select2({
                    placeholder: "Choose One",
                    allowClear: true // Enable the clear button
                });
            },
            drawCallback: function() {
                // Reinitialize Select2 after table redraw
                $('.select2').select2({
                    placeholder: "Choose One",
                    allowClear: true
                });
            }
        });

        $('#searchButton').on('click', function () {
            table.draw();
        });
        $('#clearFilters').on('click', function () {
            $('#shipment_number, #start_date, #end_date, #status_id, #driver_id').val('');
            table.draw();
        });


        $(document).on('change', '.driver-select-dropdown', function () {
            var shipmentId = $(this).data('id');
            var driverId = $(this).val();

            // AJAX request to update the driver for the shipment
            $.ajax({
                url: "{{ route('shipments.updateDriver') }}", // Define your route to handle the update
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}', // Include CSRF token
                    shipment_id: shipmentId,
                    driver_id: driverId,
                },
                success: function (response) {
                    // Handle success, maybe show a success message
                    Swal.fire(
                        'Updated!',
                        'Driver Updated Successfully',
                        'success'
                    );
                },
                error: function (xhr) {
                    // Handle error, maybe show an error message
                    console.error('Error updating driver:', xhr);
                }
            });
        });

        $('#printAllButton').on('click', function () {
            var shipmentNumber = $('#shipment_number').val();
            var startDate = $('#start_date').val();
            var endDate = $('#end_date').val();
            var statusId = $('#status_id').val();
            var driverId = $('#driver_id').val();

            window.open(`/admin/shipments/print?shipment_number=${shipmentNumber}&start_date=${startDate}&end_date=${endDate}&status_id=${statusId}&driver_id=${driverId}`, '_blank');

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
