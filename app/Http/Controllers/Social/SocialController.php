<?php

namespace App\Http\Controllers\Social;

use App\Enums\Social\SocialDriverEnum;
use App\Http\Controllers\Controller;
use App\Models\Social;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;


class SocialController extends Controller
{
    public function redirect(SocialDriverEnum $driver)
    {
        session(['social_back_url' => url()->previous()]);

        return Socialite::driver($driver->value)->redirect();
    }

    public function callback(SocialDriverEnum $driver)
    {
        try {
            $data = Socialite::driver('vkontakte')->user();
        } catch (\Exception $e) {
            report($e);

            return redirect()->to(session('social_back_url'));
        }

        $social = Social::query()
            ->firstOrCreate([
                'driver' => $driver,
                'driver_user_id' => $data->getId(),
            ]);

        if (is_null($social->user_id)) {
            $user = User::query()->create([
                'password' => Str::random(12)
            ]);
            $social->user()->associate($user)->save();
        }

        Auth::login($social->user);

        return redirect()->intended('/profile');
    }
}
