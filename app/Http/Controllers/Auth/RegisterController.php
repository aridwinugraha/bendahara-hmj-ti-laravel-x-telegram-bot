<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Registered;

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
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $re = '/\b[0IVXLCDM]+\b/';
        $str = $request->npk;
        if(preg_match("#^HMJ/#i", $str)) {
            if (preg_match("#TI/#i", $str)) {
                if(preg_match_all($re, $str)) {
                    if(preg_match("/-/", $str)) {
                        if(strlen($str)>=18) { 
                            $this->validator($request->all())->validate();
    
                            event(new Registered($user = $this->create($request->all())));
                            $this->guard()->login($user);
                            return $this->registered($request, $user)
                                            ?: redirect($this->redirectPath());
                        } else {
                            return redirect()->route('register')->withInput()
                            ->withErrors(['Input NPK anda memiliki kesalahan : Harus menyertakan nomor anggota pelantikan anda setelah tahun ajaran pelantikan']);
                        }
                    } else {
                        return redirect()->route('register')->withInput()
                        ->withErrors(['Input NPK anda memiliki kesalahan : Harus menyertakan tanda strip "-" setelah tahun angkatan anggota dan diantara tahun ajaran pelantikan']);
                    }
                } else {
                    return redirect()->route('register')->withInput()
                    ->withErrors(['Input NPK anda memiliki kesalahan : Harus menyertakan tahun angkatan anggota dalam angka romawi setelah TI/']);
                }
            } else {
                return redirect()->route('register')->withInput()
                ->withErrors(['Input NPK anda memiliki kesalahan : Harus menyertakan TI/ setelah HMJ/']);
            }
        } else {
            return redirect()->route('register')->withInput()
            ->withErrors(['Input NPK anda memiliki kesalahan : Harus menyertakan awalan HMJ/']);
        }
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
            'npk' => ['required', 'string', 'max:255', 'unique:users'],
            'name' => ['required', 'string', 'max:255'],
            'name_last' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', 'unique:users'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'jk' => ['required', 'string', 'max:20'],
            'agama' => ['required', 'string', 'max:20'],
            'status_anggota' => ['required', 'string', 'max:100'],
            'no_hp' => ['required', 'string', 'max:12'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        return User::create([
            'npk' => $data['npk'],
            'name' => $data['name'],
            'name_last' => $data['name_last'],
            'username' => $data['username'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'jk' => $data['jk'],
            'agama' => $data['agama'],
            'status_anggota' => $data['status_anggota'],
            'no_hp' => $data['no_hp'],
        ]);
    }
}
