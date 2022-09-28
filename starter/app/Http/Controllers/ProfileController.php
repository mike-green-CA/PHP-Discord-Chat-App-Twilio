<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use phpseclib\Crypt\Hash;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:profile');
    }

    public function me()
    {
        /** @var User $user */
        $user = Auth::user();

        // Lets extract the APP_KEY string to decode it.
        $appKeyString = explode(':', env('APP_KEY'));
        
        $secret = base64_decode($appKeyString[1]);

        $signature = hash('sha256', $user->name . $secret);

        return response()->json([
            'me' => [
                'id'         => $user->id,
                'name'       => $user->name,
                'picture'    => $user->picture,
                'csrf_token' => csrf_token(),
                'sig'        => $signature,
            ]
        ]);
    }

    public function all()
    {
        $users = Profile::all([
            'id', 'name', 'picture', 'email',
        ]);

        return response()->json([
            'users' => $users
        ]);
    }

    public function secretChat(){
        return view('secretChat');
    }
}
