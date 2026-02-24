<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    use HasFactory;

    protected $table = 'admin';   // explicitly set table name
    protected $primaryKey = 'id'; // primary key

    // Allow mass assignment for all fields
    protected $fillable = [
        'company',
        'case_id',
        'work_order',
        'material_order_no',
        'region',
        'engineer',
        'case_type',
        'order_type_otc_code',
        'sla',
        'multiple_visit_flag',
        'remark',
        'delay_reason_onsite',
        'received_date',
        'dispatched_date',
        'response_date',
        'maincase_close_date',
        'repair_class',
        'case_status',
        'business_segment',
        'hpi_segment',
        'serial_number',
        'product_no',
        'product_name',
        'product_line',
        'product_category_pl_code',
        'part_number',
        'part_description',
        'onsite_location_city',
        'customer',
        'zip_postal_code',
        'problem_case_subject',
        'cdax_wo_status',
        'cdax_maincase_status',
        'cdax_workorder_finished_date',
        'cdax_workorder_close_date',
        'repair_class_codes',
        'cdax_mo_status',
        'cdax_mo_failure_code',
        'backorder_etd',
        'eta_aging',
        'mo_actual_ship_date',
        'atp_status_material_order',
        'cdax_wo_count',
        'happy_call_activity_status',
        'happy_call_case_status',
        'happy_call_doa',
        'happy_call_case_status_doa',
        'maincase_open_owner',
        'maincase_open_status',
        'maincase_closed_date',
        'maincase_closed_case_resolution',
        'complaint_count',
        'cdax_wo_delay_code',
        'bookable_resource_booking_status',
        'bookable_resource_start_time',
        'sla_count_days',
        'first_wo',
        'aging_bucket_case_created',
        'aging_case_created',
        'cu_reason_breakdown',
        'gaming_m5_m7',
        'vlookup_maincase_open_created_on',
        'aging_bucket_case_received',
        'aging_case_received',
        'case_delay_dispatched',
    ];
}

?>
