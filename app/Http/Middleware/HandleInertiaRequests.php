<?php

namespace App\Http\Middleware;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Inertia\Middleware;
use Tightenco\Ziggy\Ziggy;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that's loaded on the first page visit.
     *
     * @see https://inertiajs.com/server-side-setup#root-template
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determines the current asset version.
     *
     * @see https://inertiajs.com/asset-versioning
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Defines the props that are shared by default.
     *
     * @see https://inertiajs.com/shared-data
     */
    public function share(Request $request): array
    {
        return [
            ...parent::share($request),
            'auth' => [
                //                'user' => fn() => $request->user()
                //                    ? $request->user()->only('id','name', 'email', 'avatar', 'accepted_community_rules')
                //                    : null,

                'user' => function () use ($request) {
                    $user = $request->user();

                    if (! $user) {
                        return null;
                    }

                    $userArray = $user->only('id', 'name', 'email', 'avatar', 'accepted_community_rules', 'imagen');

//                    $userArray['unreadNotificationsCount'] = $user->notifications()
//                        ->whereNull('read_at')
//                        ->count();
//
//                    $userArray['unreadNotifications'] = $user->notifications()
//                        ->where(function ($query) {
//                            $query->whereNull('read_at')
//                                ->orWhere('read_at', '>=', Carbon::now()->subWeeks(2));
//                        })
//                        ->get()
//                        ->toArray();

                    return $userArray;
                },

                'roles' => $request->user() ? $request->user()->roles->pluck('name') : [],
              //  'permissions' => $request->user() ? $request->user()->getPermissionsViaRoles()->pluck('name') : [],
            ],
            'ziggy' => fn () => [
                ...(new Ziggy)->toArray(),
                'location' => $request->url(),
            ],
            'flash' => [
                'success' => fn () => $request->session()->get('success'),
                'error' => fn () => $request->session()->get('error'),
                'warning' => fn () => $request->session()->get('warning'),
                'info' => fn () => $request->session()->get('info'),
                'message' => fn () => $request->session()->get('message'),
            ],
        ];
    }
}
