<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use League\OAuth2\Client\Provider\GenericProvider;

class LoginController extends Controller
{
    private $provider;

    public function __construct()
    {
        $this->provider = new GenericProvider([
            'clientId'                => env('OAUTH_CLIENT_ID'),
            'clientSecret'            => env('OAUTH_CLIENT_SECRET'),
            'redirectUri'             => env('OAUTH_REDIRECT_URI'),
            'urlAuthorize'            => env('OAUTH_URL_AUTHORIZE'),
            'urlAccessToken'          => env('OAUTH_TOKEN_ENDPOINT'),
            'scopes'                  => env('OAUTH_SCOPES'),
            'urlResourceOwnerDetails' => '',
        ]);
    }

    public function discord()
    {
        $this->provider->authorize();
    }

    public function logout()
    {
        Auth::guard('profile')->logout();
        Auth::guard('post')->logout();

        return redirect()->route('welcome');
    }

    public function callback(Request $request)
    {
        $request->validate(['code' => ['required', 'alpha_dash']]);
        $code  = $request->input('code');

        try
        {
            $token = $this->provider->getAccessToken('authorization_code', ['code' => $code]);

            $apiRequest = $this->provider->getAuthenticatedRequest('GET', 'https://discord.com/api/v8/users/@me', $token);
            $contents   = $this->provider->getParsedResponse($apiRequest);

            $user = User::all()
                ->where('email', $contents['email'])
                ->pop();

            if (empty($user))
            {
                return redirect()->route('login'); 
            }

            // If the user exists; we will simply change the profile picture; otherwise nothing else needs to be changed.
            $user->picture  = 'https://cdn.discordapp.com/avatars/'.$contents['id'].'/'.$contents['avatar'].'.png';
            $user->save();

            Auth::guard('post')->login($user, true);
            Auth::guard('profile')->login($user, true);

            return view('oauth-thanks', [
                'id'      => $contents['id'],
                'name'    => $contents['username'],
                'picture' => $contents['avatar'],
                'email'   => $contents['email'] ?? '',
            ]);
        }
        catch (\Exception $e)
        {
            error_log($e->getMessage());
            return view('error');
        }
    }
}
