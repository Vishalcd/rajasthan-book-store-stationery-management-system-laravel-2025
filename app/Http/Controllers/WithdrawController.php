<?php

namespace App\Http\Controllers;

use App\Models\School;
use App\Models\Withdraw;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class WithdrawController extends Controller
{
    // Show withdraw form
    public function create(School $school): View
    {
        return view('schools.withdraw', compact('school'));
    }

    // Store withdrawal + deduct revenue
    public function store(Request $request, School $school): RedirectResponse
    {
        $request->validate([
            'amount' => [
                'required',
                'numeric',
                'gt:0',
                'lte:'.$school->total_revenue,
            ],
            'note' => 'nullable|string|max:500',
        ]);


        // Store withdraw record
        Withdraw::create([
            'school_id' => $school->id,
            'amount' => $request->amount,
            'note' => $request->note,
        ]);

        // Deduct money from total_revenue
        School::where('id', $school->id)->decrement('total_revenue', $request->amount);

        return Redirect::route('schools.show', $school->id)->with('success', 'Withdrawal completed successfully.');
    }
}
