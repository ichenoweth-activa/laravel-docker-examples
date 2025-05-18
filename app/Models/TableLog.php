<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TableLog extends Model
{
    use HasFactory;

    protected $table = 'table_logs';

    protected $fillable = [
        'method',
        'message',
        'data'
    ];

}
