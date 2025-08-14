<?php

namespace App\Http\Controllers\Admin\Inventory;

use App\Http\Controllers\Controller;
use App\Models\Admin\Inventory\Laptop;
use Illuminate\Http\Request;
use Milon\Barcode\DNS1D;
use Milon\Barcode\DNS2D;
use Barryvdh\DomPDF\Facade\Pdf;

class LaptopBarcodeController extends Controller
{
    /**
     * Generate barcode untuk laptop tertentu
     */
    public function generateBarcode($id)
    {
        $laptop = Laptop::with(['region', 'getDeviceBrands'])->findOrFail($id);
        
        // Generate barcode dari serial number laptop
        $barcodeData = $laptop->serial_number ?? $laptop->id;
        $barcode = new DNS1D();
        $barcodeImage = $barcode->getBarcodePNG($barcodeData, 'C128', 3, 100);
        
        return response($barcodeImage)
            ->header('Content-Type', 'image/png')
            ->header('Content-Disposition', 'inline; filename="barcode-' . $laptop->serial_number . '.png"');
    }

    /**
     * Download PDF barcode untuk laptop tertentu
     */
    public function downloadBarcodePDF($id)
    {
        try {
            $laptop = Laptop::with(['region', 'getDeviceBrands'])->findOrFail($id);
            
            // Generate barcode
            $barcodeData = $laptop->serial_number ?? $laptop->id;
            $barcode = new DNS1D();
            $barcodeImage = $barcode->getBarcodePNG($barcodeData, 'C128', 3, 100);
            
            // Data untuk PDF
            $data = [
                'laptop' => $laptop,
                'barcodeImage' => 'data:image/png;base64,' . $barcodeImage,
                'barcodeData' => $barcodeData
            ];
            
            // Generate PDF dengan error handling
            try {
                $pdf = PDF::loadView('admin.inventory.laptops.barcode-pdf', $data);
                return $pdf->download('barcode-laptop-' . $laptop->serial_number . '.pdf');
            } catch (\Exception $e) {
                \Log::error('DomPDF Error: ' . $e->getMessage());
                return response()->json([
                    'error' => 'Gagal generate PDF: ' . $e->getMessage(),
                    'details' => [
                        'laptop_id' => $id,
                        'barcode_data' => $barcodeData,
                        'view_path' => 'admin.inventory.laptops.barcode-pdf'
                    ]
                ], 500);
            }
        } catch (\Exception $e) {
            \Log::error('Barcode Generation Error: ' . $e->getMessage());
            return response()->json([
                'error' => 'Gagal generate barcode: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Download PDF barcode untuk semua laptop
     */
    public function downloadAllBarcodesPDF(Request $request)
    {
        // Filter berdasarkan request jika ada
        $query = Laptop::with(['region', 'getDeviceBrands']);
        
        if ($request->has('kd_region') && $request->kd_region) {
            $query->where('kd_region', $request->kd_region);
        }
        
        $laptops = $query->get();
        
        // Generate barcode untuk setiap laptop
        $laptopsWithBarcodes = [];
        foreach ($laptops as $laptop) {
            $barcodeData = $laptop->serial_number ?? $laptop->id;
            $barcode = new DNS1D();
            $barcodeImage = $barcode->getBarcodePNG($barcodeData, 'C128', 2, 80);
            
            $laptopsWithBarcodes[] = [
                'laptop' => $laptop,
                'barcodeImage' => 'data:image/png;base64,' . $barcodeImage,
                'barcodeData' => $barcodeData
            ];
        }
        
        $data = [
            'laptops' => $laptopsWithBarcodes
        ];
        
        // Generate PDF
        $pdf = PDF::loadView('admin.inventory.laptops.all-barcodes-pdf', $data);
        
        return $pdf->download('barcode-semua-laptop.pdf');
    }
}
