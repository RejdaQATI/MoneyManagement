<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Transaction;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;


class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $transaction = Transaction::all();
        return response()->json([
            'transactions' => $transaction
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
    
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'amount' => 'required',
            'description' => 'nullable',
            'type' => 'required|string',
    
        ]);
    
  
        $userId = auth()->id();
    
        if (!$userId) {
            return response()->json(['error' => 'User not authenticated'], 401);
        }
        $validatedData['user_id'] = $userId;
        $transaction = Transaction::create($validatedData);
        return response()->json([
            'transaction' => $transaction
        ]);
    }
    
    /**
     * Display the specified resource.
     */

        public function show(string $id)
        {
            $transaction = Transaction::find($id);
            return $transaction;
        }
    

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'nullable|string|max:255',
            'amount' => 'nullable',
            'description' => 'nullable',
            'type' => 'nullable|string',
            'date' => 'nullable|date',
        ]);
        $transaction = Transaction::find($id);
        $transaction->update($request->all());
        return $transaction;

    }

    /**
     * Remove the specified resource from storage.
     */
 
    public function destroy(string $id)
    {
        $transaction = Transaction::find($id);
        $transaction->delete();
        return 'Transaction deleted';
    }
}

