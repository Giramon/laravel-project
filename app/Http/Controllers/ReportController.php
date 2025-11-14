<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Report;

class ReportController extends Controller
{
    public function index() {
        $sort = $request->input('sort');
        $reports = Report::paginate(6);
        return view('report.index', compact('reports'));
    }

    public function destroy(Report $report) {
        $report -> delete();
        return redirect()->back();
    }

    public function store(Request $request, Report $report) {
        $data = $request->validate([
            'number' => 'string',
            'description' => 'string',
        ]);

        $data['user_id'] = Auth::user()->id;
        $data['status_id'] = 1;

        $report->create($data);
        return redirect()->back();
    }

    public function edit(Report $report) {
        return view('report.show', compact('report'));
    }

    public function update(Request $request, Report $report) {
        $data = $request->validate([
            'number' => 'string',
            'description' => 'string',
        ]);

        $report->update($data);
        return redirect()->back();
    }
}
