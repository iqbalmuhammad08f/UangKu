<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class PasswordResetToken extends Model
{
    use HasFactory;

    protected $table = 'password_reset_tokens';

    protected $primaryKey = 'email';

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'email',
        'token',
        'created_at'
    ];

    public $timestamps = false;

    /**
     * Generate new password reset token
     */
    public static function generateToken($email)
    {
        $token = Str::random(60);

        self::updateOrCreate(
            ['email' => $email],
            [
                'token' => bcrypt($token),
                'created_at' => now()
            ]
        );

        return $token;
    }

    /**
     * Find valid token
     */
    public static function findValidToken($email, $token)
    {
        $record = self::where('email', $email)->first();

        if (!$record) {
            return null;
        }

        // Check if token is valid and not expired (1 hour)
        if (!Hash::check($token, $record->token)) {
            return null;
        }

        $tokenCreatedAt = \Carbon\Carbon::parse($record->created_at);
        if ($tokenCreatedAt->diffInHours(now()) > 1) {
            $record->delete();
            return null;
        }

        return $record;
    }

    /**
     * Delete token after use
     */
    public function deleteToken()
    {
        return $this->delete();
    }
}
