<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use GuzzleHttp\Client;

class PasswordRecoveryController extends Controller
{
    public function forgotPassword(){
        return view('passwordResetPhonePrompt');
    }

    public function passwordResetSendCode(Request $request){
        session_start();
        
        $request->validate([
            'phoneNum' => ['required', 'regex:/^\d{3}-\d{3}-\d{4}$/']
        ]);

        $phoneNum = $request->input('phoneNum');
        
        // Generate a secret code to Hash
        // To user's phone
        $secretCode         = rand(100000,999999);  
        // Hashed then later unhashed when being validated
        $secretCodeHashed   = md5($secretCode . env('HASH_SECRETCODE_SALT'));
        
        //Send an SMS via Twilio
        $id     = env('TWILIO_CLIENT_ID');
        $token  = env('TWILIO_TOKEN');
        $from   = env('TWILIO_FROM_NUM');
        
        $url    = 'https://api.twilio.com/2010-04-01/Accounts/' . $id . '/Messages.json';
        
        $to     = $phoneNum;

        $client = new Client();  
        $client->request('POST', $url, [
            'auth'          => [$id, $token],
            'form_params'   => [
                'From'  => $from,
                'To'    => $to,
                'Body'  => 'Here is your secret code for password reseting: ' . $secretCode
            ]
        ]);

        $_SESSION['secretCode'] = $secretCodeHashed;
        $_SESSION['phoneNum']   = $phoneNum;

        return view('passwordResetCodeConfirm');
    }

    // This method will be called when phoneConfirm() has a validate error and 302 GET request
    public function passwordResetSendCodeErr(Request $request)
    {
        session_start();
        return view('passwordResetCodeConfirm');
    }

    public function passwordResetCodeCheck(Request $request){

        $request->validate([
            'trySecretCode' => ['required', 'alpha_num']
        ]);

        session_start();
        //Check if the input matches the hashed REAL code.
        //If it fails redirect.
        if( md5($request->input('trySecretCode') . env('HASH_SECRETCODE_SALT')) !== $_SESSION['secretCode']){
            return redirect()->route('passwordResetCodeCheck');
        }

        return view('passwordReset');
    }

    public function passwordResetCodeCheckErr(Request $request)
    {
        session_start();
        return view('passwordReset');
    }

    public function passwordReset(Request $request){
        $request->validate([
            'password'      => ['required', 'alpha_num'],
            'verify_password'  => ['required', 'same:password']
        ]);

        session_start();
        
        $user = User::all()->where('phoneNumber', $_SESSION['phoneNum'])->pop();
        $user->password = $request->input('password');

        $user->save();

        return redirect()->route('passwordResetThankYou');
    }

    public function passwordResetThankYou(){
        session_start();
        return view('passwordResetThankYou');
    }

    public function sendToLogin(){
        session_start();
        session_destroy();

        return redirect()->route('login');
    }

}