<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin;

class CaseController extends Controller
{
    // Case Management dashboard
    public function index()
    {
        return view('caseManagement');
    }

    // JSON for DataTables
    public function getCasesJson()
    {
        return Admin::all();
    }

    // Store new case
    public function store(Request $request)
    {
        $validated = $request->validate($this->rules());
        Admin::create($validated);

        return redirect()->route('case.management')->with('success', 'Case added successfully!');
    }

    // JSON detail for AJAX
    public function show($id)
    {
        return Admin::findOrFail($id);
    }

    // Read-only detail page
    public function showDetails($id)
    {
        $case = Admin::findOrFail($id);
        return view('caseDetails', compact('case'));
    }

    // Editable detail page
    public function editAdmin($id)
    {
        $case = Admin::findOrFail($id);

        // Get distinct values directly from the admin table
        $engineers = Admin::select('engineer')->distinct()->pluck('engineer');
        $regions = Admin::select('region')->distinct()->pluck('region');
        $caseStatuses = Admin::select('case_status')->distinct()->pluck('case_status');

        return view('caseEdit', compact('case','engineers','regions','caseStatuses'));
    }

    public function edit($id)
{
    $case = Admin::findOrFail($id);

    $columns = [
        'company','case_id','work_order','material_order_no','region','engineer','case_type',
        'order_type_otc_code','sla','multiple_visit_flag','remark','delay_reason_onsite',
        'received_date','dispatched_date','response_date','maincase_close_date','repair_class',
        'case_status','business_segment','hpi_segment','serial_number','product_no','product_name',
        'product_line','product_category_pl_code','part_number','part_description','onsite_location_city',
        'customer','zip_postal_code','problem_case_subject','cdax_wo_status','cdax_maincase_status',
        'cdax_workorder_finished_date','cdax_workorder_close_date','repair_class_codes','cdax_mo_status',
        'cdax_mo_failure_code','backorder_etd','eta_aging','mo_actual_ship_date','atp_status_material_order',
        'cdax_wo_count','happy_call_activity_status','happy_call_case_status','happy_call_doa',
        'happy_call_case_status_doa','maincase_open_owner','maincase_open_status','maincase_closed_date',
        'maincase_closed_case_resolution','complaint_count','cdax_wo_delay_code',
        'bookable_resource_booking_status','bookable_resource_start_time','sla_count_days','first_wo',
        'aging_bucket_case_created','aging_case_created','cu_reason_breakdown','gaming_m5_m7',
        'vlookup_maincase_open_created_on','aging_bucket_case_received','aging_case_received',
        'case_delay_dispatched'
    ];

    $distincts = [];
    foreach ($columns as $col) {
        $distincts[$col] = Admin::select($col)->distinct()->pluck($col);
    }

    return view('caseEdit', compact('case','distincts'));
}



    // Update case
    public function update(Request $request, $id)
    {
        $validated = $request->validate($this->rules());
        $case = Admin::findOrFail($id);
        $case->update($validated);

        return redirect()->route('cases.edit', $id)->with('success', 'Case updated successfully!');
    }

    // Validation rules for all columns
    private function rules()
    {
        return [
            'company' => 'nullable|string|max:100',
            'case_id' => 'required|string|max:50',
            'work_order' => 'required|string|max:50',
            'material_order_no' => 'required|string|max:50',
            'region' => 'nullable|string|max:100',
            'engineer' => 'nullable|string|max:100',
            'case_type' => 'nullable|string|max:50',
            'order_type_otc_code' => 'nullable|string|max:50',
            'sla' => 'nullable|string|max:50',
            'multiple_visit_flag' => 'nullable|string|max:10',
            'remark' => 'nullable|string|max:255',
            'delay_reason_onsite' => 'nullable|string|max:255',
            'received_date' => 'nullable|date',
            'dispatched_date' => 'nullable|date',
            'response_date' => 'nullable|date',
            'maincase_close_date' => 'nullable|date',
            'repair_class' => 'nullable|string|max:50',
            'case_status' => 'nullable|string|max:50',
            'business_segment' => 'nullable|string|max:100',
            'hpi_segment' => 'nullable|string|max:100',
            'serial_number' => 'nullable|string|max:100',
            'product_no' => 'nullable|string|max:50',
            'product_name' => 'nullable|string|max:255',
            'product_line' => 'nullable|string|max:100',
            'product_category_pl_code' => 'nullable|string|max:50',
            'part_number' => 'nullable|string|max:50',
            'part_description' => 'nullable|string|max:255',
            'onsite_location_city' => 'nullable|string|max:100',
            'customer' => 'nullable|string|max:255',
            'zip_postal_code' => 'nullable|string|max:20',
            'problem_case_subject' => 'nullable|string|max:255',
            'cdax_wo_status' => 'nullable|string|max:50',
            'cdax_maincase_status' => 'nullable|string|max:50',
            'cdax_workorder_finished_date' => 'nullable|date',
            'cdax_workorder_close_date' => 'nullable|date',
            'repair_class_codes' => 'nullable|string|max:50',
            'cdax_mo_status' => 'nullable|string|max:50',
            'cdax_mo_failure_code' => 'nullable|string|max:50',
            'backorder_etd' => 'nullable|date',
            'eta_aging' => 'nullable|string|max:50',
            'mo_actual_ship_date' => 'nullable|date',
            'atp_status_material_order' => 'nullable|string|max:50',
            'cdax_wo_count' => 'nullable|integer',
            'happy_call_activity_status' => 'nullable|string|max:50',
            'happy_call_case_status' => 'nullable|string|max:50',
            'happy_call_doa' => 'nullable|string|max:50',
            'happy_call_case_status_doa' => 'nullable|string|max:50',
            'maincase_open_owner' => 'nullable|string|max:100',
            'maincase_open_status' => 'nullable|string|max:50',
            'maincase_closed_date' => 'nullable|date',
            'maincase_closed_case_resolution' => 'nullable|string|max:255',
            'complaint_count' => 'nullable|integer',
            'cdax_wo_delay_code' => 'nullable|string|max:50',
            'bookable_resource_booking_status' => 'nullable|string|max:50',
            'bookable_resource_start_time' => 'nullable|date',
            'sla_count_days' => 'nullable|integer',
            'first_wo' => 'nullable|string|max:50',
            'aging_bucket_case_created' => 'nullable|string|max:50',
            'aging_case_created' => 'nullable|integer',
            'cu_reason_breakdown' => 'nullable|string|max:255',
            'gaming_m5_m7' => 'nullable|string|max:50',
            'vlookup_maincase_open_created_on' => 'nullable|date',
            'aging_bucket_case_received' => 'nullable|string|max:50',
            'aging_case_received' => 'nullable|integer',
            'case_delay_dispatched' => 'nullable|string|max:50',
        ];
    }
}
