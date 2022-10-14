<?php

namespace Pondo\Oauth;

use App\Models\OauthToken;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class OAuth
{
    public static function redirect()
    {
        $query = http_build_query([
            'client_id' => env('PONDO_OAUTH_CLIENT_ID'),
            'redirect_uri' => env('PONDO_OAUTH_REDIRECT_URI'),
            'response_type' => 'code',
            'scope' => ''
        ]);
    
        return redirect('https://accounts.pondo.co.id/oauth/authorize?'.$query);
    }

    public static function callback($code = '')
    {
        $token = Http::withOptions([
            'verify' => false
        ])->post('https://accounts.pondo.co.id/oauth/token', [
            'grant_type' => 'authorization_code',
            'client_id' => env('PONDO_OAUTH_CLIENT_ID'),
            'client_secret' => env('PONDO_OAUTH_CLIENT_SECRET'),
            'redirect_uri' => env('PONDO_OAUTH_REDIRECT_URI'),
            'code' => $code
        ]);
        $token = $token->json();

        $OauthToken = Http::withOptions([
            'verify' => false
        ])->withHeaders([
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer ' . $token['access_token'],
        ])->get('https://accounts.pondo.co.id/api/user');

        $jsonResponse = [
            'status' => $OauthToken->status(),
            'info' => $OauthToken->json(),
            'access_token' => $token['access_token']
        ];

        return $jsonResponse;
    }

    public static function getCustomers($access_token, $params)
    {
        $customers = Http::withOptions([
            'verify' => false
        ])->withHeaders([
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer ' . $access_token
        ])->get('https://dev.pondo.co.id/api/customers?' . $params);

        return $customers;
    }
}
