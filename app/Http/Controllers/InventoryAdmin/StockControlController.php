<?php

namespace App\Http\Controllers\InventoryAdmin;

use App\Http\Controllers\Controller;
use App\Models\DivisionItem;
use App\Models\DivisionRequest;
use App\Models\InventoryItem;
use App\Models\ItemEntry;
use App\Models\StockControl;
use Carbon\Carbon;
use Dompdf\Dompdf;
use Dompdf\Options;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StockControlController extends Controller
{
    public function index()
    {
        $inventoryItems = InventoryItem::all();
        return view('inventory_admin.stock_controls.index', compact('inventoryItems'));
    }

    public function print(Request $request)
    {
        // Validasi request
        $request->validate([
            'inventory_item_id' => 'required|exists:inventory_items,id',
            'from_date' => 'nullable|date',
            'to_date' => 'nullable|date|after_or_equal:from_date',
        ]);

        $inventoryItemId = $request->inventory_item_id;
        $fromDate = $request->from_date;
        $toDate = $request->to_date;

        // Validasi bahwa jika salah satu tanggal diisi, yang lainnya juga harus diisi
        if (($fromDate && !$toDate) || (!$fromDate && $toDate)) {
            return redirect()->back()->withErrors(['from_date' => 'Tanggal mulai dan tanggal akhir harus diisi secara bersamaan.']);
        }

        // Ambil semua data dari tabel stock_controls berdasarkan kondisi tanggal
        if ($fromDate && $toDate) {
            $stockControls = StockControl::where('inventory_item_id', $inventoryItemId)
                ->whereBetween('date', [$fromDate, $toDate])
                ->orderBy('date', 'asc')
                ->get();
        } else {
            $stockControls = StockControl::where('inventory_item_id', $inventoryItemId)
                ->orderBy('date', 'asc')
                ->get();
        }

        // Ambil nama item dari inventory_item_id
        $inventoryItem = InventoryItem::find($inventoryItemId);
        $itemName = $inventoryItem->name;

        // Membagi data menjadi potongan-potongan dengan ukuran 30
        $chunkedData = $stockControls->chunk(30);

        $time = \Carbon\Carbon::now();

        // Render view dengan data yang telah diproses
        $html = view('inventory_admin.stock_controls.print', [
            'chunkedData' => $chunkedData,
            'time' => $time,
            'itemName' => $itemName, // Kirimkan itemName ke view
        ])->render();



        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', true);

        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'potrait');
        $dompdf->render();

        $pageCount = $dompdf->getCanvas()->get_page_count();

        session(['pageCount' => $pageCount]);

        $output = $dompdf->output();

        return response()->stream(
            function () use ($output) {
                print($output);
            },
            200,
            [
                "Content-Type" => "application/pdf",
                "Content-Disposition" => "inline; filename=document.pdf",
            ]
        );
    }
}
