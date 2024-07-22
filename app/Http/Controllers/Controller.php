<?php

namespace App\Http\Controllers;

use App\Models\DivisionLoan;
use App\Models\DivisionRequest;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function __construct()
    {
        view()->composer('*', function ($view) {
            $pendingRequestsCount = Auth::check() ? DivisionRequest::countPendingRequests() : 0;
            $overdueBorrowedLoansCount = Auth::check() ? DivisionLoan::countOverdueBorrowedLoans() : 0;
            
            $view->with('pendingRequestsCount', $pendingRequestsCount)
                 ->with('overdueBorrowedLoansCount', $overdueBorrowedLoansCount);
        });
    }


}
