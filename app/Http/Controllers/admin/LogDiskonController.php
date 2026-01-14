<?php

namespace App\Http\Controllers\admin;

use App\DataTables\LogDiskonDataTable;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LogDiskonController extends Controller
{
    public function index(LogDiskonDataTable $dataTable, Request $request)
    {
        $request->validate([
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ]);

        $start_date = $request->start_date ?? null;
        $end_date = $request->end_date ?? $start_date;

        return $dataTable->with([
            'start_date' => $start_date,
            'end_date' => $end_date,
        ])->render('pages.admin.log-diskon.index', compact([
            'start_date',
            'end_date',
        ]));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        //
    }

    public function update(Request $request, string $uuid)
    {
        //
    }

    public function destroy(string $uuid)
    {
        //
    }
}
