<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasRoles;
    use HasUuids;
    use Notifiable;


    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $incrementing = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'temporal_password',
        'password',
        'google_id',
        'avatar',
        'personalized_avatar',
        'provider_token',
        'provider_refresh_token',
        'provider_created',
        'provider_expires_in',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
    ];
    protected $appends = ['role', 'imagen'];



//    public function getRoleAttribute()
//    {
//        if ($this->hasRole('admin')) {
//            return 'admin';
//        } elseif ($this->hasRole('instructor')) {
//            return 'instructor';
//        } elseif ($this->hasRole('student')) {
//            return 'student';
//        } else {
//            return 'SIN ROL ASIGNADO';
//        }
//    }

    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }


//    public function imagen(): Attribute
//    {
//        return Attribute::make(
//            get: fn(mixed $value, array $attributes) =>
//            $attributes['personalized_avatar'] !== null
//                ? Storage::disk('gcs')->temporaryUrl(
//                $attributes['personalized_avatar'],
//                now()->addDay()
//            )
//                : $attributes['avatar']
//        );
//    }
}
