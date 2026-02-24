<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CaseModel extends Model
{
    use HasFactory;

    protected $table = 'cases'; // name of your database table

    protected $fillable = [
        'case_id',
        'work_order',
        'material_order_no',
        'sla',
        'received_date',
        'dispatched_date',
        'part_number',
        'part_description',
        'onsite_location_city',
        'zip_postal_code',
    ];
}
