<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Auth;

class IndexController extends Controller
{
    public function index()
    {
        return view('welcome');
    }

    public function login()
    {
        return view('login');
        //return redirect()->route('dashboard');
    }

    public function loginAuthorization(Request $request)
    {
        $request->validate([
            'email'     => ['required'],
            'password'  => ['required'],
        ]);

        // alright lets see if there is an email in our database that matches the input
        $doesUserExist = User::where('email','=',$request->input('email'))->first();

        // If null that means the user is not in the database and the email is wrong
        if($doesUserExist === null){
            return redirect()->route('login');
        }

        // Ok so we found the user now lets check its password against our input
        // If it matches we'll go to Dashboard, if not back to log in.

        // Now for this particular function for login we'll need to extract the ID and AVATAR values from the DB obj's picture
        // The default picture is:                    ID                   Picture
        // https://cdn.discordapp.com/avatars/957162199699312700/99d7e2ee0566fe84bfe47cbbb7143b40.png
        
        // The first split will contain the pure id; and 99d7e2ee0566fe84bfe47cbbb7143b40.png so we'll do a second split on the last object.
        $variableswithID = preg_split('#/#', $doesUserExist->getAttribute('picture'));

        // If you var_dump variablewithID you'll see object 5 has the last object to split.
        $variableswithPicture = explode(".", $variableswithID[5]);

        // Var_dumps will tell us:
        // variableswithID[4] will contain our "id" and variableswithPicture[0] will contain our "picture".

        Auth::guard('post')->login($doesUserExist, true);
        Auth::guard('profile')->login($doesUserExist, true);

        if($doesUserExist->getAttribute('password') === $request->input('password')){
            return redirect()->route('dashboard');
        }
        else{
            return redirect()->route('login');
        }
    }

    public function signup()
    {
        return view('signup');
    }

    public function about()
    {
        return view('about');
    }

    public function dashboard()
    {
        return view('dashboard');
    }

    public function confirmPhoneLanding(Request $request)
    {

        $request->validate([
            'username'      => ['required', 'alpha_num'],
            'email'         => ['required', 'email'],
            'age'           => ['required', 'integer'],
            'phoneNum'      => ['required', 'regex:/^\d{3}-\d{3}-\d{4}$/'],
            'password'      => ['required', 'alpha_num'],
            'verify_password'  => ['required', 'same:password']
        ]);

        $username   = $request->input('username');
        $email      = $request->input('email');
        $age        = $request->input('age');
        $phoneNum   = $request->input('phoneNum');
        $password   = $request->input('password');

        //Send an SMS via Twilio
        $id     = env('TWILIO_CLIENT_ID');
        $token  = env('TWILIO_TOKEN');
        $from   = env('TWILIO_FROM_NUM');
        
        $url    = 'https://api.twilio.com/2010-04-01/Accounts/' . $id . '/Messages.json';
        
        $to     = $phoneNum;

        // Generate a secret code to Hash
        // To user's phone
        $secretCode         = rand(100000,999999);  
        // Hashed then later unhashed when being validated
        $secretCodeHashed   = md5($secretCode . env('HASH_SECRETCODE_SALT')); 

        $client = new Client();  
        $client->request('POST', $url, [
            'auth'          => [$id, $token],
            'form_params'   => [
                'From'  => $from,
                'To'    => $to,
                'Body'  => 'Thank you ' . $username . ' for signing up! Here is your secret code: ' . $secretCode
            ]
        ]);

        // These will only be used to pass the user's enter data around during the phone number verification phase
        // and destroyed after account creation.
        session_start();
        $_SESSION["username"]   = $request->input('username');
        $_SESSION["email"]      = $request->input('email');
        $_SESSION["age"]        = $request->input('age');
        $_SESSION["phoneNum"]   = $request->input('phoneNum');
        $_SESSION["password"]   = $request->input('password');
        $_SESSION["secretCode"] = $secretCodeHashed;

        return view('confirmphonelanding', [
            'username' => $username,
            'email' => $email,
            'age' => $age,
            'phoneNum' => $phoneNum,
            'password' => $password,
            'secretCode' => $secretCode,
        ]);
    }

    // This method will be called when phoneConfirm() has a validate error and 302 GET request
    public function confirmPhoneLandingErr(Request $request)
    {
        session_start();
        var_dump($_SESSION);
        return view('confirmphonelanding');
    }

    public function phoneConfirm(Request $request)
    {   
        session_start();        

        $request->validate([
            'trySecretCode' => ['required', 'alpha_num']
        ]);

        // Check if the input matches the hashed REAL code.
        // If it fails redirect.
        if( md5($request->input('trySecretCode') . env('HASH_SECRETCODE_SALT')) !== $_SESSION['secretCode']){
            return redirect()->route('signup');
        }

        // PHONE CODE VALIDATED!
        // TIME TO ADD ACCOUNT TO DATABASE
        // Default picture
        $defaultIDValue     = "957162199699312700";
        $defaultAvatarValue = "99d7e2ee0566fe84bfe47cbbb7143b40";
        
        $user = new User();

        $user->name         = $_SESSION['username'];
        $user->picture      = 'https://cdn.discordapp.com/avatars/'.$defaultIDValue.'/'.$defaultAvatarValue.'.png';
        $user->email        = $_SESSION['email'] ?? 'errorEditEmail@gmail.com';
        $user->password     = $_SESSION['password'];
        $user->phoneNumber  = $_SESSION['phoneNum'];

        $user->save();
        

        // The secret code was provided and matched
        $username   = $_SESSION['username'];
        $email      = $_SESSION['email'];
        $age        = $_SESSION['age'];

        try{
            return view('thanks', [
                        'username' => $username,
                        'email' => $email,
                        'age' => $age,  
                        ]);
        }
        finally{
            session_destroy();
        }
        
    }

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
            return redirect()->route('signup');
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
        
        var_dump($_SESSION);

        $user = User::all()->where('phoneNumber', $_SESSION['phoneNum'])->pop();
        $user->password = $request->input('password');

        $user->save();

        echo '<br/>';

        echo 'Complete?';

        echo '<br/>';

        var_dump($user);
    }


    public function thanks(Request $request)
    {
        session_start();
        var_dump($_SESSION);
        $username   = $request->input('username');
        $email      = $request->input('email');
        $age        = $request->input('age');
        $phoneNum   = $request->input('phoneNum');
        $password   = $request->input('password');

        return view('thanks', [
            'username' => $username,
            'email' => $email,
            'age' => $age,
        ]);
    }
}
