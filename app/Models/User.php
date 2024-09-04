<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     schema="User",
 *     title="User",
 *     description="User model",
 *     @OA\Property(
 *         property="id",
 *         description="The unique identifier of the user",
 *         type="integer",
 *         format="int64"
 *     ),
 *     @OA\Property(
 *         property="name",
 *         description="The name of the user",
 *         type="string"
 *     ),
 *     @OA\Property(
 *         property="email",
 *         description="The email address of the user",
 *         type="string",
 *         format="email"
 *     ),
 *     @OA\Property(
 *         property="password",
 *         description="The password of the user",
 *         type="string"
 *     ),
 *     @OA\Property(
 *         property="email_verified_at",
 *         description="The timestamp when the user email was verified",
 *         type="string",
 *         format="date-time"
 *     ),
 *     @OA\Property(
 *         property="profile_photo_url",
 *         description="URL of the user's profile photo",
 *         type="string",
 *         format="uri"
 *     ),
 *     @OA\Property(
 *         property="created_at",
 *         description="The timestamp when the user was created",
 *         type="string",
 *         format="date-time"
 *     ),
 *     @OA\Property(
 *         property="updated_at",
 *         description="The timestamp when the user was last updated",
 *         type="string",
 *         format="date-time"
 *     )
 * )
 */
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, HasProfilePhoto, Notifiable, TwoFactorAuthenticatable;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    protected $appends = [
        'profile_photo_url',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}
