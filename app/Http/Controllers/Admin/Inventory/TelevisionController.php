<?php

namespace App\Http\Controllers\Admin\Inventory;

use App\Http\Controllers\Controller;
use App\Http\Requests\TelevisionRequest;
use App\Models\Admin\Inventory\Television;
use App\Models\Admin\MasterData\DeviceBrand;
use App\Models\Admin\MasterData\Region;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use App\Exports\AllTelevisionsExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

class TelevisionController extends Controller
{
    private $television;
    private $region;
    private $brand;
    public function __construct(Television $television, Region $region, DeviceBrand $brand)
    {
        $this->television = $television;
        $this->region = $region;
        $this->brand = $brand;
    }

    function index(Request $request)
    {
        $query = $this->television->newQuery();

        if ($request->filled('kd_region')) {
            $query->where('kd_region', $request->kd_region);
        }

        $datas = $query->with('brand', 'region')->get();

        return view('admin.inventory.television.index', [
            'datas' => $datas,
            'regions' => $this->region->getAllData()
        ]);
    }

    public function exportExcel(Request $request)
    {
        $kd_region = $request->query('kd_region');
        return Excel::download(new AllTelevisionsExport($kd_region), 'laporan_television.xlsx');
    }

    public function exportPdf(Request $request)
    {
        $kd_region = $request->query('kd_region');

        $query = $this->television->newQuery();

        if ($kd_region) {
            $query->where('kd_region', $kd_region);
        }

        $datas = $query->with('brand', 'region')->get();

        $pdf = PDF::loadView('admin.inventory.television.pdf_view', compact('datas'));
        $pdf->setPaper('a4', 'landscape');

        return $pdf->download('laporan_television.pdf');
    }

    public function create()
    {
        return view('admin.inventory.television.create', [
            'regions' => $this->region->getAllData(),
            'brands' => $this->brand->getBrandTelevision()
        ]);
    }


    public function store(TelevisionRequest $request)
    {
        try {
            // dd($request->validated());
            if ($request->hasfile('bast')) {
                $filename = round(microtime(true) * 1000) . '-' . str_replace(' ', '-', $request->file('bast')->getClientOriginalName());
                $file = $request->file('bast');
                Storage::disk('local')->put('bast/television/' . $filename, File::get($file));
                $data = [
                    'serial_number' => $request->serial_number,
                    'brand_id' => $request->brand_id,
                    'model' => $request->model,
                    'kd_region' => $request->kd_region,
                    'status_asset' => $request->status_asset,
                    'keterangan' => $request->keterangan,
                    'bast' => $filename
                ];
                $this->television->create($data);
            } else {
                $this->television->create($request->validated());
            }
        } catch (\Exception $e) {
            dd($e);
            return redirect()->back()->withInput()->with('error', 'Gagal Tambah Data Komputer');
        }
        return redirect()->route('television.index')->with('success', 'Berhasil Tambah Data Komputer');
    }


    public function show()
    {
        //
    }


    public function edit(Television $television)
    {
        return view('admin.inventory.television.edit', [
            'television' => $television,
            'regions' => $this->region->getAllData(),
            'brands' => $this->brand->getBrandTelevision()
        ]);
    }


    public function update(TelevisionRequest $request, Television $television)
    {
        if ($request->hasfile('bast')) {

            if (!empty($television->bast)) {
                Storage::disk('local')->delete('bast/television/' . $television->bast);
            }

            $filename = round(microtime(true) * 1000) . '-' . str_replace(' ', '-', $request->file('bast')->getClientOriginalName());
            $file = $request->bast;
            Storage::disk('local')->put('bast/television/' . $filename, File::get($file));

            $data = [
                'serial_number' => $request->serial_number,
                'brand_id' => $request->brand_id,
                'model' => $request->model,
                'kd_region' => $request->kd_region,
                'status_asset' => $request->status_asset,
                'status_id' => $request->status_id,
                'keterangan' => $request->keterangan,
                'bast' => $filename
            ];

            $television->update($data);
        } else {

            $television->update($request->validated());
        }

        return redirect()->route('television.index')->with('success', 'Berhasil Mengubah Data television');
    }


    public function destroy(Television $television)
    {
        if (!empty($television->bast)) {
            Storage::disk('local')->delete('bast/television/' . $television->bast);
        }
        $television->delete();
        return redirect()->route('television.index')->with('success', 'Berhasil Hapus Data television');
    }
}
