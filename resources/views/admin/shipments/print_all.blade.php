<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print Shipments</title>
    <style>
        @page {
            size: A4;
            margin: 20mm;
        }
        body {
            font-family: Arial, sans-serif;
            font-size: 10px; /* Reduced font size */
        }
        .content {
            width: 100%;
            max-width: 210mm;
            margin: auto;
            border: 1px solid #ddd; /* Border to visualize A4 size */
            padding: 10mm;
        }
        .heading {
            text-align: center;
            margin-bottom: 20px;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            page-break-inside: auto;
        }
        .table th, .table td {
            padding: 8px;
            border: 1px solid #ddd;
            text-align: left;
        }
        .table th {
            /* Set column widths */
            width: 5%; /* Sr# */
        }
        .table th:nth-child(2) { width: 20%; } /* Consignment # */
        .table th:nth-child(3) { width: 25%; } /* Consignee Name */
        .table th:nth-child(4) { width: 20%; } /* Received By */
        .table th:nth-child(5) { width: 15%; } /* Delivery Time */
        .table th:nth-child(6) { width: 15%; } /* Delivery Status */

        .table tbody tr {
            page-break-inside: avoid; /* Avoid breaking rows across pages */
        }
        .page-break {
            page-break-after: always;
        }
        input.form-control {
            width: 100%; /* Make input fields take full column width */
            font-size: 14px; /* Reduced font size for input fields */
            padding: 4px; /* Reduced padding for input fields */
            border: 1px solid #ddd;
            border-radius: 4px; /* Optional: adds a little rounding to the corners */
        }
    </style>
</head>
<body onload="window.print()">
    <div class="content">
        <div class="heading">
            <h2>Shipments List</h2>
        </div>
        <table class="table">
            <thead>
                <tr>
                    <th>Sr#</th>
                    <th>Consignment #</th>
                    <th>Consignee Name</th>
                    <th>Received By</th>
                    <th>Delivery Time</th>
                    <th>Delivery Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($shipments as $index => $shipment)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $shipment->shipment_number }}</td>
                    <td>{{ $shipment->sender->full_name }}</td>
                    <td>
                        @if($shipment->status_id == 5)
                            {{ $shipment->received_by ?? '' }}
                        @else
                            <input type="text" />
                        @endif
                    </td>
                    
                    <td>
                        @if($shipment->status_id == 5)
                            {{ $shipment->actual_delivery_date ?? '' }}
                        @else
                            <input type="text" />
                        @endif
                    </td>
                    
                    <td>
                        @if($shipment->status_id == 5)
                            {{ $shipment->status->name ?? '' }}
                        @else
                            <input type="text" />
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>
