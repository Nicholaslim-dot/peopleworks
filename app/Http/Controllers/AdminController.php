<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\CasesImport;
use Illuminate\Support\Facades\Cache;

class AdminController extends Controller
{
    public function getData()
    {
        $data = Admin::all();
        return response()->json($data);
    }

    public function import(Request $request)
    {
        if (!$request->hasFile('excel_file')) {
            return back()->withErrors(['excel_file' => 'No file was uploaded']);
        }

        if (!$request->file('excel_file')->isValid()) {
            return back()->withErrors(['excel_file' => 'Upload error: '.$request->file('excel_file')->getErrorMessage()]);
        }

        $request->validate([
            'excel_file' => 'required|file|mimes:xlsx,xls,csv|max:51200',
            'sheet_name' => 'required|string',
        ]);

        Excel::import(new CasesImport($request->input('sheet_name')), $request->file('excel_file'));

        return back()->with('success', 'Cases imported successfully!');
    }

    public function dashboard()
    {
        $activeUsers = Cache::get('active_users_list', []);

        // Remove expired entries
        $activeUsers = array_filter($activeUsers, function ($expiry) {
            return $expiry->isFuture();
        });

        $count = count($activeUsers);

        return view('admin.dashboard', [
            'activeUsers' => $count
        ]);
    }

    public function getCase($caseId)
    {
        $records = Admin::where('case_id', $caseId)
            ->get([
                'case_id',
                'work_order',
                'engineer',
                'material_order_no',
                'part_number',
                'part_description',
                'customer'
            ]);

        if ($records->isEmpty()) {
            return response()->json(['error' => 'Case not found'], 404);
        }

        // Group by WO
        $grouped = $records->groupBy('work_order');

        return response()->json($grouped);
    }

}
