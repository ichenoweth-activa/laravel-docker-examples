<?php

namespace App\Models\Google\Console;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use HasFactory;

    protected $table = 'console_users';

    protected $fillable = [
        'consola',
        'name',
        'google_id',
        'email',
        'provider_token',
        'provider_refresh_token',
        'provider_expires_in',
        'provider_created',
        'scopes',
    ];

    protected $casts = [
        //        'provider_created' => 'timestamp',
        'scopes' => 'array',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class, 'console_client_id');
    }

    public function getScopesArrayAttribute()
    {
        return is_array($this->scopes) ? $this->scopes : (array) json_decode((string) $this->scopes, true);
    }
}
