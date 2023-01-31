<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\MailCadastro;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'indicacao' => ['string', 'max:255','exists:users,username'],
            //'celular' => ['required', 'string', 'max:255'],
            //'cpf' => ['required', 'string', 'max:255','unique:users'],
            'username' => ['required', 'string', 'max:191', 'unique:users'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users','confirmed'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            //'g-recaptcha-response' => 'required|captcha',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'username' => preg_replace("/\s+/", "", $data['username']),
            'password' => Hash::make($data['password']),
            'indicacao' => $data['indicacao'],
            //'celular'=> preg_replace('/[^0-9]/', '', $data['celular']),
            //'cpf'=> preg_replace('/[^0-9]/', '', $data['cpf']),
            'type' => User::DEFAULT_TYPE,
        ]);

        $wallet = new Wallet;
        $wallet->user_id = $user->id;
        $wallet->saldo = "0.00";
        $wallet->save();
        //Mail::to($user->email)->send(new MailCadastro($user));
        return $user;
    }
}
