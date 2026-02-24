<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeaveApplication extends Model
{
    use HasFactory;

    protected $fillable = [
        'employeeName',
        'employeeId',
        'leaveType',
        'department',
        'startDate',
        'endDate',
        'dayType',       // full, half_am, half_pm
        'totalDays',
        'reason',
        'contactInfo',
        'handoverNotes',
    ];
}
