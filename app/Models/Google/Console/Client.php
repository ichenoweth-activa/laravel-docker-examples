<?php

namespace App\Models\Google\Console;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    protected $table = 'console_clients';

    protected $casts = [
        'client_data' => 'array',
    ];

    protected $fillable = [
        'descripcion',
        'client_data',
    ];

    public function users()
    {
        return $this->hasMany(User::class, 'console_client_id');
    }

    public function getClientIdAttribute()
    {
        //mover
        return $this->client['web']['client_id'];
    }

    public function getClientSecretAttribute()
    {
        //mover
        return $this->client['web']['client_secret'];
    }
}
