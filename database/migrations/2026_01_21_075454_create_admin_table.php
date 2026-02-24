<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('admin', function (Blueprint $table) {
            $table->id(); // primary key "id"

            $table->string('company')->nullable();
            $table->string('case_id')->nullable();
            $table->string('work_order')->nullable();
            $table->string('material_order_no')->nullable();
            $table->string('region')->nullable();
            $table->string('engineer')->nullable();
            $table->string('case_type')->nullable();
            $table->string('order_type_otc_code')->nullable();
            $table->string('sla')->nullable();
            $table->string('multiple_visit_flag')->nullable();
            $table->text('remark')->nullable();
            $table->string('delay_reason_onsite')->nullable();
            $table->date('received_date')->nullable();
            $table->date('dispatched_date')->nullable();
            $table->date('response_date')->nullable();
            $table->date('maincase_close_date')->nullable();
            $table->string('repair_class')->nullable();
            $table->string('case_status')->nullable();
            $table->string('business_segment')->nullable();
            $table->string('hpi_segment')->nullable();
            $table->string('serial_number')->nullable();
            $table->string('product_no')->nullable();
            $table->string('product_name')->nullable();
            $table->string('product_line')->nullable();
            $table->string('product_category_pl_code')->nullable();
            $table->string('part_number')->nullable();
            $table->string('part_description')->nullable();
            $table->string('onsite_location_city')->nullable();
            $table->string('customer')->nullable();
            $table->string('zip_postal_code')->nullable();
            $table->text('problem_case_subject')->nullable();
            $table->string('cdax_wo_status')->nullable();
            $table->string('cdax_maincase_status')->nullable();
            $table->date('cdax_workorder_finished_date')->nullable();
            $table->date('cdax_workorder_close_date')->nullable();
            $table->string('repair_class_codes')->nullable();
            $table->string('cdax_mo_status')->nullable();
            $table->string('cdax_mo_failure_code')->nullable();
            $table->date('backorder_etd')->nullable();
            $table->string('eta_aging')->nullable();
            $table->date('mo_actual_ship_date')->nullable();
            $table->string('atp_status_material_order')->nullable();
            $table->integer('cdax_wo_count')->nullable();
            $table->string('happy_call_activity_status')->nullable();
            $table->string('happy_call_case_status')->nullable();
            $table->string('happy_call_doa')->nullable();
            $table->string('happy_call_case_status_doa')->nullable();
            $table->string('maincase_open_owner')->nullable();
            $table->string('maincase_open_status')->nullable();
            $table->date('maincase_closed_date')->nullable();
            $table->text('maincase_closed_case_resolution')->nullable();
            $table->integer('complaint_count')->nullable();
            $table->string('cdax_wo_delay_code')->nullable();
            $table->string('bookable_resource_booking_status')->nullable();
            $table->time('bookable_resource_start_time')->nullable();
            $table->integer('sla_count_days')->nullable();
            $table->string('first_wo')->nullable();
            $table->string('aging_bucket_case_created')->nullable();
            $table->string('aging_case_created')->nullable();
            $table->string('cu_reason_breakdown')->nullable();
            $table->string('gaming_m5_m7')->nullable();
            $table->date('vlookup_maincase_open_created_on')->nullable();
            $table->string('aging_bucket_case_received')->nullable();
            $table->string('aging_case_received')->nullable();
            $table->string('case_delay_dispatched')->nullable();

            $table->timestamps(); // created_at & updated_at
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('admin');
    }
};
