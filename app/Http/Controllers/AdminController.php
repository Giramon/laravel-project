<?php

namespace App\Http\Controllers;
use App\Http\Middleware\Admin;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index(Request $request) {
        

        return view('admin.index');
    }
}
