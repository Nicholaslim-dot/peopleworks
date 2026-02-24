<?php

namespace App\Imports;

use App\Models\Admin;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class CasesSheetImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        return new Admin([
            'company'                          => $this->normalizeValue($row['company'] ?? null),
            'case_id'                          => $this->normalizeValue($row['case_id'] ?? null),
            'work_order'                       => $this->normalizeValue($row['work_order'] ?? null),
            'material_order_no'                => $this->normalizeValue($row['material_order_mo_no'] ?? null),
            'region'                           => $this->normalizeValue($row['region'] ?? null),
            'engineer'                         => $this->normalizeValue($row['engineer'] ?? null),
            'case_type'                        => $this->normalizeValue($row['case_type'] ?? null),
            'order_type_otc_code'              => $this->normalizeValue($row['order_type_otc_code'] ?? null),
            'sla'                              => $this->normalizeValue($row['sla'] ?? null),
            'multiple_visit_flag'              => $this->normalizeValue($row['multiple_visit_flag'] ?? null),
            'remark'                           => $this->normalizeValue($row['remark'] ?? null),
            'delay_reason_onsite'              => $this->normalizeValue($row['delay_reason_onsite'] ?? null),

            // DATE fields
            'received_date'                    => $this->transformDate($this->normalizeValue($row['received_date'] ?? null)),
            'dispatched_date'                  => $this->transformDate($this->normalizeValue($row['dispatched_date'] ?? null)),
            'response_date'                    => $this->transformDate($this->normalizeValue($row['response_date'] ?? null)),
            'maincase_close_date'              => $this->transformDate($this->normalizeValue($row['maincase_close_date'] ?? null)),
            'cdax_workorder_finished_date'     => $this->transformDate($this->normalizeValue($row['cdax_workorder_finisheddate'] ?? null)),
            'cdax_workorder_close_date'        => $this->transformDate($this->normalizeValue($row['cdax_workorder_closedate'] ?? null)),
            'backorder_etd'                    => $this->transformDate($this->normalizeValue($row['backorder_etd'] ?? null)),
            'mo_actual_ship_date'              => $this->transformDate($this->normalizeValue($row['mo_actual_ship_date'] ?? null)),
            'maincase_closed_date'             => $this->transformDate($this->normalizeValue($row['maincase_closed_date'] ?? null)),
            'vlookup_maincase_open_created_on' => $this->transformDate($this->normalizeValue($row['vlookup_maincase_open_created_on'] ?? null)),
            'aging_case_received'              => $this->transformDate($this->normalizeValue($row['aging_case_received'] ?? null)),
            'bookable_resource_start_time'     => $this->transformDate($this->normalizeValue($row['bookable_resource_start_time'] ?? null)),

            // Other fields
            'repair_class'                     => $this->normalizeValue($row['repair_class'] ?? null),
            'case_status'                      => $this->normalizeValue($row['case_status'] ?? null),
            'business_segment'                 => $this->normalizeValue($row['business_segment'] ?? null),
            'hpi_segment'                      => $this->normalizeValue($row['hpi_segment'] ?? null),
            'serial_number'                    => $this->normalizeValue($row['serial_number'] ?? null),
            'product_no'                       => $this->normalizeValue($row['product_no'] ?? null),
            'product_name'                     => $this->normalizeValue($row['product_name'] ?? null),
            'product_line'                     => $this->normalizeValue($row['product_line'] ?? null),
            'product_category_pl_code'         => $this->normalizeValue($row['product_category_pl_code'] ?? null),
            'part_number'                      => $this->normalizeValue($row['part_number'] ?? null),
            'part_description'                 => $this->normalizeValue($row['part_description'] ?? null),
            'onsite_location_city'             => $this->normalizeValue($row['onsite_location_city'] ?? null),
            'customer'                         => $this->normalizeValue($row['customer'] ?? null),
            'zip_postal_code'                  => $this->normalizeValue($row['zip_postal_code'] ?? null),
            'problem_case_subject'             => $this->normalizeValue($row['problem_case_subject'] ?? null),
            'cdax_wo_status'                   => $this->normalizeValue($row['cdax_wo_status'] ?? null),
            'cdax_maincase_status'             => $this->normalizeValue($row['cdax_maincase_status'] ?? null),
            'repair_class_codes'               => $this->normalizeValue($row['repair_class_codes'] ?? null),
            'cdax_mo_status'                   => $this->normalizeValue($row['cdax_mo_status'] ?? null),
            'cdax_mo_failure_code'             => $this->normalizeValue($row['cdax_mo_failure_code'] ?? null),
            'eta_aging'                        => $this->normalizeValue($row['eta_aging'] ?? null),
            'atp_status_material_order'        => $this->normalizeValue($row['atp_status_material_order'] ?? null),
            'cdax_wo_count'                    => $this->normalizeValue($row['cdax_wo_count'] ?? null),
            'happy_call_activity_status'       => $this->normalizeValue($row['happy_call_activitystatus'] ?? null),
            'happy_call_case_status'           => $this->normalizeValue($row['happy_call_case_status'] ?? null),
            'happy_call_doa'                   => $this->normalizeValue($row['happy_call_doa'] ?? null),
            'happy_call_case_status_doa'       => $this->normalizeValue($row['happy_call_case_status_doa'] ?? null),
            'maincase_open_owner'              => $this->normalizeValue($row['maincase_open_owner'] ?? null),
            'maincase_open_status'             => $this->normalizeValue($row['maincase_open_status'] ?? null),
            'maincase_closed_case_resolution'  => $this->normalizeValue($row['maincase_closed_case_resolution'] ?? null),
            'complaint_count'                  => $this->normalizeValue($row['complaint_count'] ?? null),
            'cdax_wo_delay_code'               => $this->normalizeValue($row['cdax_wo_delay_code'] ?? null),
            'bookable_resource_booking_status' => $this->normalizeValue($row['bookable_resource_booking_status'] ?? null),
            'sla_count_days'                   => $this->normalizeValue($row['sla_count_days'] ?? null),
            'first_wo'                         => $this->normalizeValue($row['first_wo'] ?? null),
            'aging_bucket_case_created'        => $this->normalizeValue($row['aging_bucket_case_created'] ?? null),
            'aging_case_created'               => $this->normalizeValue($row['aging_case_created'] ?? null),
            'cu_reason_breakdown'              => $this->normalizeValue($row['cu_reason_breakdown'] ?? null),
            'gaming_m5_m7'                     => $this->normalizeValue($row['gaming_m5_m7'] ?? null),
            'aging_bucket_case_received'       => $this->normalizeValue($row['aging_bucket_case_received'] ?? null),
            'case_delay_dispatched'            => $this->normalizeValue($row['case_delay_dispatched'] ?? null),
        ]);
    }

    private function transformDate($value)
    {
        try {
            if (!$value) return null;

            // If it's a string like "20/06/2024"
            if (preg_match('/\d{2}\/\d{2}\/\d{4}/', $value)) {
                return Carbon::createFromFormat('d/m/Y', $value)->format('Y-m-d');
            }

            // If it's an Excel serial number
            if (is_numeric($value)) {
                return Carbon::instance(Date::excelToDateTimeObject($value))->format('Y-m-d');
            }

            // Try parsing any other format
            return Carbon::parse($value)->format('Y-m-d');
        } catch (\Exception $e) {
            Log::warning("Invalid date value: ".$value);
            return null;
        }
    }

    private function normalizeValue($value)
    {
        if ($value === null) {
            return null;
        }

        // Trim spaces and unify casing
        $val = trim((string)$value);

        // Treat Excel error placeholders as null
        $invalids = ['#N/A', 'N/A', 'NA', '?', '-', 'null', 'NULL', '#VALUE!'];
        if (in_array($val, $invalids, true)) {
            return null;
        }

        return $val;
    }
}

?>
