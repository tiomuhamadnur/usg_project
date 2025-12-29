<?php

namespace App\Http\Controllers\admin;

use App\DataTables\CampaignDataTable;
use App\Http\Controllers\Controller;
use App\Models\Campaign;
use Illuminate\Http\Request;

class CampaignController extends Controller
{
    public function index(CampaignDataTable $dataTable)
    {
        return $dataTable->render('pages.admin.campaign.index');
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'string|required',
            'code' => 'string|required|unique:unit,code'
        ]);

        Campaign::updateOrCreate($data, $data);

        return redirect()->route('campaign.index')->withNotify('Data berhasil ditambahkan');
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
        $data = Campaign::where('uuid', $uuid)->firstOrFail();
        $rawData = $request->validate([
            'name' => 'string|required',
            'code' => 'string|required'
        ]);

        $data->update($rawData);
        return redirect()->route('campaign.index')->withNotify('Data berhasil diubah');
    }

    public function destroy(string $uuid)
    {
        $data = Campaign::where('uuid', $uuid)->firstOrFail();
        $data->delete();
        return redirect()->route('campaign.index')->withNotify('Data berhasil dihapus');
    }
}
