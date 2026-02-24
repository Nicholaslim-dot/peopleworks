@extends('layouts.app')

@section('content')
<div class="container-fluid mt-4">
    <h3 class="mb-3">Case Management</h3>

    <!-- Filters row -->
    <div class="row mb-3">
        <div class="col-md-8">
            <form class="form-inline" id="overviewFilters">
                <select class="form-control mr-2" id="overviewBranch">
                    <option value="">All Branches</option>
                </select>
            </form>
        </div>
        <div class="col-md-4 text-right" id="datatableLengthMenu"></div>
    </div>

    <!-- Tabs -->
    <ul class="nav nav-tabs" id="caseTabs" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" id="overview-tab" data-toggle="tab" href="#overview" role="tab">Overview</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="open-tab" data-toggle="tab" href="#open" role="tab">Open Case</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="close-tab" data-toggle="tab" href="#close" role="tab">Close Case</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="add-tab" data-toggle="tab" href="#add" role="tab">Add Case</a>
        </li>
    </ul>

    <div class="tab-content mt-3">
        <!-- Overview Tab -->
        <div class="tab-pane fade show active" id="overview" role="tabpanel">
            <table class="table table-striped table-bordered nowrap" id="overviewTable" style="width:100%">
                <thead class="thead-dark">
                    <tr>
                        <th>No.</th>
                        <th>Company</th>
                        <th>Case ID</th>
                        <th>Work Order</th>
                        <th>Material Order No</th>
                        <th>Region</th>
                        <th>Engineer</th>
                        <th>Case Type</th>
                        <th>Order Type OTC Code</th>
                        <th>SLA</th>
                        <th>Multiple Visit Flag</th>
                        <th>Remark</th>
                        <th>Delay Reason Onsite</th>
                        <th>Received Date</th>
                        <th>Dispatched Date</th>
                        <th>Response Date</th>
                        <th>Maincase Close Date</th>
                        <th>Repair Class</th>
                        <th>Case Status</th>
                        <th>Business Segment</th>
                        <th>HPI Segment</th>
                        <th>Serial Number</th>
                        <th>Product No</th>
                        <th>Product Name</th>
                        <th>Product Line</th>
                        <th>Product Category PL Code</th>
                        <th>Part Number</th>
                        <th>Part Description</th>
                        <th>Onsite Location City</th>
                        <th>Customer</th>
                        <th>Zip Postal Code</th>
                        <th>Problem Case Subject</th>
                        <th>Cdax WO Status</th>
                        <th>Cdax Maincase Status</th>
                        <th>Cdax Workorder Finished Date</th>
                        <th>Cdax Workorder Close Date</th>
                        <th>Repair Class Codes</th>
                        <th>Cdax MO Status</th>
                        <th>Cdax MO Failure Code</th>
                        <th>Backorder ETD</th>
                        <th>ETA Aging</th>
                        <th>MO Actual Ship Date</th>
                        <th>ATP Status Material Order</th>
                        <th>Cdax WO Count</th>
                        <th>Happy Call Activity Status</th>
                        <th>Happy Call Case Status</th>
                        <th>Happy Call DOA</th>
                        <th>Happy Call Case Status DOA</th>
                        <th>Maincase Open Owner</th>
                        <th>Maincase Open Status</th>
                        <th>Maincase Closed Date</th>
                        <th>Maincase Closed Case Resolution</th>
                        <th>Complaint Count</th>
                        <th>Cdax WO Delay Code</th>
                        <th>Bookable Resource Booking Status</th>
                        <th>Bookable Resource Start Time</th>
                        <th>SLA Count Days</th>
                        <th>First WO</th>
                        <th>Aging Bucket Case Created</th>
                        <th>Aging Case Created</th>
                        <th>CU Reason Breakdown</th>
                        <th>Gaming M5 M7</th>
                        <th>Vlookup Maincase Open Created On</th>
                        <th>Aging Bucket Case Received</th>
                        <th>Aging Case Received</th>
                        <th>Case Delay Dispatched</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>

        <!-- Open Case Tab -->
        <div class="tab-pane fade" id="open" role="tabpanel">
            <table class="table table-striped table-bordered nowrap" id="openTable" style="width:100%">
                <thead class="thead-dark">
                    <tr>
                        <th>No.</th>
                        <th>Case ID</th>
                        <th>Material Order No</th>
                        <th>Work Order</th>
                        <th>Region</th>
                        <th>Engineer</th>
                        <th>Case Status</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>

        <!-- Close Case Tab -->
        <div class="tab-pane fade" id="close" role="tabpanel">
            <table class="table table-striped table-bordered nowrap" id="closeTable" style="width:100%">
                <thead class="thead-dark">
                    <tr>
                        <th>No.</th>
                        <th>Case ID</th>
                        <th>Material Order No</th>
                        <th>Work Order</th>
                        <th>Region</th>
                        <th>Engineer</th>
                        <th>Case Status</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>

        <!-- Add Case Tab -->
        <div class="tab-pane fade" id="add" role="tabpanel">
            <form id="addCaseForm" method="POST" action="{{ route('cases.store') }}">
                @csrf
                <div class="form-group">
                    <label for="case_id">Case ID</label>
                    <input type="text" class="form-control" id="case_id" name="case_id" required>
                </div>
                <div class="form-group">
                    <label for="work_order">Work Order (WO No)</label>
                    <input type="text" class="form-control" id="work_order" name="work_order" required>
                </div>
                <div class="form-group">
                    <label for="material_order_no">Material Order (MO No)</label>
                    <input type="text" class="form-control" id="material_order_no" name="material_order_no" required>
                </div>
                <div class="form-group">
                    <label for="sla">SLA</label>
                    <input type="text" class="form-control" id="sla" name="sla" required>
                </div>
                <div class="form-group">
                    <label for="received_date">Received Date</label>
                    <input type="date" class="form-control" id="received_date" name="received_date" required>
                </div>
                <div class="form-group">
                    <label for="dispatched_date">Dispatched Date</label>
                    <input type="date" class="form-control" id="dispatched_date" name="dispatched_date" required>
                </div>
                <div class="form-group">
                    <label for="part_number">Part Number</label>
                    <input type="text" class="form-control" id="part_number" name="part_number" required>
                </div>
                <div class="form-group">
                    <label for="part_description">Part Description</label>
                    <input type="text" class="form-control" id="part_description" name="part_description" required>
                </div>
                <div class="form-group">
                    <label for="onsite_location_city">Onsite Location (City)</label>
                    <input type="text" class="form-control" id="onsite_location_city" name="onsite_location_city" required>
                </div>
                <div class="form-group">
                    <label for="zip_postal_code">Zip/Postal Code</label>
                    <input type="text" class="form-control" id="zip_postal_code" name="zip_postal_code" required>
                </div>
                <button type="submit" class="btn btn-primary">Add Case</button>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    function numberRows(table) {
        table.on('order.dt search.dt draw.dt', function() {
            let pageInfo = table.page.info();
            table.column(0, { search: 'applied', order: 'applied' })
                .nodes()
                .each(function(cell, i) {
                    cell.innerHTML = pageInfo.start + i + 1;
                });
        }).draw();
    }

    // Overview Table
    const overviewTable = $('#overviewTable').DataTable({
        ajax: { url: '{{ route("cases.json") }}', dataSrc: '' },
        scrollX: true,
        pageLength: 10,
        order: [[2, 'asc']],
        dom: '<"top"f>rt<"bottom"ip><"clear">',
        columns: [
            { data: null },
            { data: 'company' },
            {
                data: 'case_id',
                render: function(data, type, row) {
                    if (type === 'display') {
                        return `<a href="/cases/${row.id}/edit" target="_blank">${data}</a>`;
                    }
                    return data;
                }
            },
            { data: 'work_order' },
            { data: 'material_order_no' },
            { data: 'region' },
            { data: 'engineer' },
            { data: 'case_type' },
            { data: 'order_type_otc_code' },
            { data: 'sla' },
            { data: 'multiple_visit_flag' },
            { data: 'remark' },
            { data: 'delay_reason_onsite' },
            { data: 'received_date' },
            { data: 'dispatched_date' },
            { data: 'response_date' },
            { data: 'maincase_close_date' },
            { data: 'repair_class' },
            { data: 'case_status' },
            { data: 'business_segment' },
            { data: 'hpi_segment' },
            { data: 'serial_number' },
            { data: 'product_no' },
            { data: 'product_name' },
            { data: 'product_line' },
            { data: 'product_category_pl_code' },
            { data: 'part_number' },
            { data: 'part_description' },
            { data: 'onsite_location_city' },
            { data: 'customer' },
            { data: 'zip_postal_code' },
            { data: 'problem_case_subject' },
            { data: 'cdax_wo_status' },
            { data: 'cdax_maincase_status' },
            { data: 'cdax_workorder_finished_date' },
            { data: 'cdax_workorder_close_date' },
            { data: 'repair_class_codes' },
            { data: 'cdax_mo_status' },
            { data: 'cdax_mo_failure_code' },
            { data: 'backorder_etd' },
            { data: 'eta_aging' },
            { data: 'mo_actual_ship_date' },
            { data: 'atp_status_material_order' },
            { data: 'cdax_wo_count' },
            { data: 'happy_call_activity_status' },
            { data: 'happy_call_case_status' },
            { data: 'happy_call_doa' },
            { data: 'happy_call_case_status_doa' },
            { data: 'maincase_open_owner' },
            { data: 'maincase_open_status' },
            { data: 'maincase_closed_date' },
            { data: 'maincase_closed_case_resolution' },
            { data: 'complaint_count' },
            { data: 'cdax_wo_delay_code' },
            { data: 'bookable_resource_booking_status' },
            { data: 'bookable_resource_start_time' },
            { data: 'sla_count_days' },
            { data: 'first_wo' },
            { data: 'aging_bucket_case_created' },
            { data: 'aging_case_created' },
            { data: 'cu_reason_breakdown' },
            { data: 'gaming_m5_m7' },
            { data: 'vlookup_maincase_open_created_on' },
            { data: 'aging_bucket_case_received' },
            { data: 'aging_case_received' },
            { data: 'case_delay_dispatched' }
        ]
    });
    numberRows(overviewTable);

    // Open Case Table
    const openTable = $('#openTable').DataTable({
        ajax: {
            url: '{{ route("cases.json") }}',
            dataSrc: json => json.filter(row => {
                const status = (row.case_status || '').toLowerCase();
                return !(status.includes('closed') || status.includes('completed'));
            })
        },
        scrollX: true,
        pageLength: 10,
        order: [[1, 'asc']],
        dom: '<"top"f>rt<"bottom"ip><"clear">',
        columns: [
            { data: null },
            {
                data: 'case_id',
                render: function(data, type, row) {
                    if (type === 'display') {
                        return `<a href="/cases/${row.id}/edit" target="_blank">${data}</a>`;
                    }
                    return data;
                }
            },
            { data: 'material_order_no' },
            { data: 'work_order' },
            { data: 'region' },   // index 4
            { data: 'engineer' },
            { data: 'case_status' }
        ]
    });
    numberRows(openTable);

    // Close Case Table
    const closeTable = $('#closeTable').DataTable({
        ajax: {
            url: '{{ route("cases.json") }}',
            dataSrc: json => json.filter(row => {
                const status = (row.case_status || '').toLowerCase();
                return (status.includes('closed') || status.includes('completed'));
            })
        },
        scrollX: true,
        pageLength: 10,
        order: [[1, 'asc']],
        dom: '<"top"f>rt<"bottom"ip><"clear">',
        columns: [
            { data: null },
            {
                data: 'case_id',
                render: function(data, type, row) {
                    if (type === 'display') {
                        return `<a href="/cases/${row.id}/edit" target="_blank">${data}</a>`;
                    }
                    return data;
                }
            },
            { data: 'material_order_no' },
            { data: 'work_order' },
            { data: 'region' },   // index 4
            { data: 'engineer' },
            { data: 'case_status' }
        ]
    });
    numberRows(closeTable);

    // Branch dropdown
    overviewTable.on('xhr.dt', function() {
        const data = overviewTable.ajax.json();
        const branchSet = new Set(data.map(row => row.region));
        const dropdown = $('#overviewBranch');
        dropdown.empty().append('<option value="">All Branches</option>');
        branchSet.forEach(branch => {
            dropdown.append('<option value="' + branch + '">' + branch + '</option>');
        });
    });

    // Apply branch filter
    function applyBranchFilter(val) {
        overviewTable.column(5).search(val).draw();
        openTable.column(4).search(val).draw();
        closeTable.column(4).search(val).draw();
    }
    $('#overviewBranch').on('change', function() {
        applyBranchFilter(this.value);
    });

    // Fix header alignment when switching tabs
    $('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
        $.fn.dataTable.tables({visible: true, api: true}).columns.adjust();
    });
});
</script>
@endpush

