<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NotificationController extends Controller
{
    public function __invoke(Request $request): void
    {
        DB::table('notifications')
            ->where('notifiable_id', auth()->user()->id)
            ->whereNull('read_at')
            ->update(['read_at' => Carbon::now()]);
    }
}
