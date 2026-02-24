<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LeaveApplication;

class LeaveController extends Controller
{
    public function submit(Request $request)
    {
        $validated = $request->validate([
            'employeeName'   => 'required|string|max:255',
            'employeeId'     => 'required|string|max:50',
            'leaveType'      => 'required|string',
            'department'     => 'required|string|max:255',
            'startDate'      => 'required|date',
            'endDate'        => 'required|date|after_or_equal:startDate',
            'dayType'        => 'required|in:full,half_am,half_pm',
            'totalDays'      => 'required|numeric|min:0.5',
            'reason'         => 'required|string',
            'contactInfo'    => 'nullable|string|max:255',
            'handoverNotes'  => 'nullable|string',
        ]);

        LeaveApplication::create($validated);

        return redirect()->route('leave.apply')->with('success', 'Leave application submitted successfully!');
    }
    public function review(Request $request)
    {
        $query = \App\Models\LeaveApplication::query();

        // Filters
        if ($request->filled('department')) {
            $query->where('department', $request->department);
        }

        if ($request->filled('employeeName')) {
            $query->where('employeeName', 'like', '%' . $request->employeeName . '%');
        }

        if ($request->filled('startDate')) {
            $query->whereDate('startDate', '>=', $request->startDate);
        }

        if ($request->filled('endDate')) {
            $query->whereDate('endDate', '<=', $request->endDate);
        }

        $applications = $query->latest()->paginate(20);

        return view('leaveReview', compact('applications'));
    }

    public function accept($id)
    {
        $application = \App\Models\LeaveApplication::findOrFail($id);
        $application->status = 'accepted';
        $application->save();

        return redirect()->route('leave.review')->with('success', 'Leave application accepted.');
    }

    public function decline($id)
    {
        $application = \App\Models\LeaveApplication::findOrFail($id);
        $application->status = 'declined';
        $application->save();

        return redirect()->route('leave.review')->with('success', 'Leave application declined.');
    }


}
