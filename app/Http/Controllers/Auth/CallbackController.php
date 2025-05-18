<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\AllowedUser;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class CallbackController extends Controller
{
    public function __invoke(Request $request)
    {
        try {
            $googleUser = Socialite::driver('google')->user();
        } catch (\Exception) {
            return redirect()->route('landing');
        }

        //        if( !AllowedUser::where('email', $googleUser->email)->exists() )
        //        {
        //            return redirect()->route('landing');
        //        }

//        $user = User::query()
//            ->where('email', $googleUser->email)
//            ->first();
//
//        if (! $user) {
//            return redirect()->route('solicitud.correonopermitido', ['email' => $googleUser->email]);
//        }

        $campos = [];
        if ($googleUser->refreshToken) {
            $campos['provider_refresh_token'] = $googleUser->refreshToken;
        }

        $user = User::updateOrCreate([
            'email' => $googleUser->email,
        ], [
            'name' => $googleUser->name,
            'google_id' => $googleUser->id,
            'avatar' => $googleUser->avatar,
            'provider_token' => $googleUser->token,
            //'provider_created' => Carbon::now(),
            'provider_created' => $googleUser->created,
            'provider_expires_in' => $googleUser->expiresIn,
            'temporary_password' => null,
            'accepted_community_rules' => true,
            ...$campos,
        ]);

        $request->session()->regenerate();
        Auth::login($user);

        return to_route('project.index');
       // return redirect('/inicio');
    }
}
