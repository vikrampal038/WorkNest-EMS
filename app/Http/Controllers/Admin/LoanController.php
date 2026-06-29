<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Loan;

class LoanController extends Controller
{
    public function index()
    {
        $loans = Loan::with('user')->latest()->get();
        return view('admin.loans', compact('loans'));
    }

    public function store(Request $request)
    {
        return redirect()->back();
    }
}
