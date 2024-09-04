<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     schema="Transaction",
 *     title="Transaction",
 *     description="Transaction model",
 *     @OA\Property(
 *         property="id",
 *         description="The unique identifier of the transaction",
 *         type="integer",
 *         format="int64"
 *     ),
 *     @OA\Property(
 *         property="name",
 *         description="The name of the transaction",
 *         type="string"
 *     ),
 *     @OA\Property(
 *         property="amount",
 *         description="The amount of the transaction",
 *         type="number",
 *         format="float"
 *     ),
 *     @OA\Property(
 *         property="description",
 *         description="A description of the transaction",
 *         type="string"
 *     ),
 *     @OA\Property(
 *         property="type",
 *         description="The type of the transaction (e.g., credit or debit)",
 *         type="string"
 *     ),
 *     @OA\Property(
 *         property="user_id",
 *         description="The ID of the user associated with the transaction",
 *         type="integer",
 *         format="int64"
 *     ),
 *     @OA\Property(
 *         property="created_at",
 *         description="The timestamp when the transaction was created",
 *         type="string",
 *         format="date-time"
 *     ),
 *     @OA\Property(
 *         property="updated_at",
 *         description="The timestamp when the transaction was last updated",
 *         type="string",
 *         format="date-time"
 *     )
 * )
 */
class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'amount',
        'description',
        'type',
        'user_id'
    ];
}
