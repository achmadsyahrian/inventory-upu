<?php

namespace App\Http\Controllers\InventoryAdmin;

use App\Http\Controllers\Controller;
use App\Models\Division;
use App\Models\DivisionLoan;
use App\Models\DivisionRequest;
use App\Models\InventoryItem;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {

        $users = User::whereNotIn('role_id', [1])->count();
        $divisions = Division::count();

        $inventoryItemConsum = InventoryItem::where('type_id', 1)->count();
        $inventoryItemNonConsum = InventoryItem::where('type_id', 2)->count();

        // Permintaan Barang
        $itemRequestTotal = DivisionRequest::count();
        $itemRequestPending = DivisionRequest::where('status', 'pending')->count();
        $itemRequestComplete = DivisionRequest::where('status', 'approved')->count();
        $itemRequestReject = DivisionRequest::where('status', 'rejected')->count();
        
        // Peminjaman Barang
        $divisionLoanTotal = DivisionLoan::count();
        $divisionLoanBorrow = DivisionLoan::where('status', 'borrowed')->count();
        $divisionLoanReturn = DivisionLoan::where('status', 'returned')->count();
        $divisionLoanLate = DivisionLoan::where('status', 'borrowed')
                            ->where('due_date', '<', Carbon::now())
                            ->count();
        
        return view('inventory_admin.dashboard', compact(
            'users', 'divisions', 
            'inventoryItemConsum', 'inventoryItemNonConsum', 
            'itemRequestTotal', 'itemRequestPending', 'itemRequestComplete', 'itemRequestReject',
            'divisionLoanTotal', 'divisionLoanBorrow', 'divisionLoanReturn', 'divisionLoanLate'
        ));
    }
}
