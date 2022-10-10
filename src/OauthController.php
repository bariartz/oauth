<?php

namespace Pondo\Oauth;

use App\Models\OauthToken;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class OAuthController
{
    public static function redirect()
    {
        $query = http_build_query([
            'client_id' => env('PONDO_OAUTH_CLIENT_ID'),
            'redirect_uri' => env('PONDO_OAUTH_REDIRECT_URI'),
            'response_type' => 'code',
            'scope' => ''
        ]);
    
        return redirect('http://127.0.0.1:8000/oauth/authorize?'.$query);
    }

    public static function callback($code = '')
    {
        $token = Http::post('http://127.0.0.1:8000/oauth/token', [
            'grant_type' => 'authorization_code',
            'client_id' => env('PONDO_OAUTH_CLIENT_ID'),
            'client_secret' => env('PONDO_OAUTH_CLIENT_SECRET'),
            'redirect_uri' => env('PONDO_OAUTH_REDIRECT_URI'),
            'code' => $code
        ]);
        $token = $token->json();

        $OauthToken = Http::withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $token['access_token'],
        ])->get('http://127.0.0.1:8000/api/user');

        if($OauthToken->status() == 200) {
            $response = $OauthToken->json();
            $createUser = User::updateOrCreate([
                'email' => $response['email'],
            ],
            [
                'name' => $response['name'],
                'password' => Hash::make(Str::random(20)),
                'remember_token' => Str::random(60),
                'login_with' => 'pondo'
            ]);
            OauthToken::create([
                'user_id' => $createUser->id,
                'access_token' => $token['access_token'],
            ]);
            Auth::loginUsingId($createUser->id);
        }

        return redirect('/home');
    }
}
