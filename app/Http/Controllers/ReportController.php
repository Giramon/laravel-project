<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Report;
use App\Models\Status;

class ReportController extends Controller
{
    public function index(Request $request) {
        $sort = $request->input('sort');
        if($sort != 'asc' && $sort != 'desc') {
            $sort = 'desc';
        }

        $status = $request->input('status');

        $validate = $request->validate([
            'status' => 'exists:statuses,id'
        ]);

        if($validate) {
            $reports = Report::where('status_id',$status)->where('user_id', Auth::user()->id)->orderBy('created_at', $sort)->paginate(6);
        } else {
            $reports = Report::orderBy('created_at', $sort)->where('user_id', Auth::user()->id)->paginate(6);
        }

        $statuses = Status::all();

        return view('report.index', compact('reports','statuses','sort','status'));
    }

    public function destroy(Report $report) {
        if(Auth::user()->id === $report->user_id) {
            $report -> delete();
            return redirect()->back();
        } else {
            abort(403, 'Увас нет прав на редактирование этой записи');
        }
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
        if(Auth::user()->id === $report->user_id) {
            return view('report.show', compact('report'));
        } else {
            abort(403, 'Увас нет прав на редактирование этой записи');
        }
    }

    public function update(Request $request, Report $report) {
        if(Auth::user()->id === $report->user_id) {
            $data = $request->validate([
                'number' => 'string',
                'description' => 'string',
            ]);

            $report->update($data);
            return redirect()->back();
        } else {
            abort(403, 'Увас нет прав на редактирование этой записи');
        }
    }
}
