<?php

namespace App\Http\Controllers;
use App\Http\Middleware\Admin;
use Illuminate\Http\Request;
use App\Models\Report;
use App\Models\Status;
use App\Models\User;

class AdminController extends Controller
{
    public function index(Request $request) {

        $status = $request->input('status');

        $validate = $request->validate([
            'status' => 'exists:statuses,id'
        ]);

        if($validate) {
            $reports = Report::with('user')->where('status_id', $status)->paginate(50);
        } else {
            $reports = Report::with('user')->paginate(50);
        }

        $statuses = Status::all();

        return view('admin.index', compact('reports','statuses','status'));
    }
}
