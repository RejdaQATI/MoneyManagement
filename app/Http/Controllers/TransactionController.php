<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use OpenApi\Annotations as OA;

/**
 * @OA\Tag(
 *     name="Transactions",
 *     description="Operations related to transactions"
 * )
 */
class TransactionController extends Controller
{
    

    /**
     * @OA\Get(
     *     path="/api/transactions",
     *     summary="List all transactions for the authenticated user",
     *     tags={"Transactions"},
     *     @OA\Response(
     *         response=200,
     *         description="List of transactions",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="transactions",
     *                 type="array",
     *                 @OA\Items(ref="#/components/schemas/Transaction")
     *             )
     *         )
     *     )
     * )
     */
    public function index()
    {
        $userId = auth()->id();
        $transactions = Transaction::where('user_id', $userId)->get();
        return response()->json([
            'transactions' => $transactions
        ]);
    }

    /**
     * @OA\Post(
     *     path="/api/transactions",
     *     summary="Create a new transaction",
     *     tags={"Transactions"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(ref="#/components/schemas/Transaction")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Transaction created",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="transaction",
     *                 ref="#/components/schemas/Transaction"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="User not authenticated"
     *     )
     * )
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
        ], 201);
    }

    /**
     * @OA\Get(
     *     path="/api/transactions/{id}",
     *     summary="Get a transaction by ID for the authenticated user",
     *     tags={"Transactions"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the transaction",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Transaction details",
     *         @OA\JsonContent(ref="#/components/schemas/Transaction")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Transaction not found"
     *     )
     * )
     */
    public function show(string $id)
    {
        $userId = auth()->id();
        $transaction = Transaction::where('id', $id)->where('user_id', $userId)->first();

        if (!$transaction) {
            return response()->json(['error' => 'Transaction not found'], 404);
        }

        return $transaction;
    }

    /**
     * @OA\Put(
     *     path="/api/transactions/{id}",
     *     summary="Update an existing transaction",
     *     tags={"Transactions"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the transaction",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(ref="#/components/schemas/Transaction")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Transaction updated",
     *         @OA\JsonContent(ref="#/components/schemas/Transaction")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Transaction not found"
     *     )
     * )
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

        $userId = auth()->id();
        $transaction = Transaction::where('id', $id)->where('user_id', $userId)->first();

        if (!$transaction) {
            return response()->json(['error' => 'Transaction not found'], 404);
        }

        $transaction->update($request->all());
        return $transaction;
    }

    /**
     * @OA\Delete(
     *     path="/api/transactions/{id}",
     *     summary="Delete a transaction",
     *     tags={"Transactions"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the transaction",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Transaction deleted",
     *         @OA\JsonContent(
     *             type="string",
     *             example="Transaction deleted"
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Transaction not found"
     *     )
     * )
     */
    public function destroy(string $id)
    {
        $userId = auth()->id();
        $transaction = Transaction::where('id', $id)->where('user_id', $userId)->first();

        if (!$transaction) {
            return response()->json(['error' => 'Transaction not found'], 404);
        }

        $transaction->delete();
        return response()->json(['message' => 'Transaction deleted']);
    }
}
