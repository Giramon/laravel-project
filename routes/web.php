<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/reports', [ReportController::class, 'index'])->name('report.index');

Route::get('/reports/create', function () {
    return view('report.create');
})->name('reports.create');