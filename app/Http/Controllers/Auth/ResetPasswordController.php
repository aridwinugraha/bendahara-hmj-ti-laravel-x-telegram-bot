<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Contracts\Hashing\Hasher as HasherContract;
use Illuminate\Auth\Passwords\DatabaseTokenRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
// use Illuminate\Support\Str;
// use App\Providers\RouteServiceProvider;
// use Illuminate\Foundation\Auth\ResetsPasswords;
use Telegram\Bot\Laravel\Facades\Telegram;
use Telegram\Bot\Keyboard\Keyboard;
use Telegram\Bot\Commands\Command;
use DB;
use App\User;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    /**
     * The hashing key.
     *
     * @var string
     */
    protected $hashKey;

    // use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    // protected $redirectTo = RouteServiceProvider::HOME;

    public function createNewToken()
    {
        return hash_hmac('sha256', Str::random(40), $this->hashKey);
    }

    public function compare(Request $request)
    {
        $email = User::where('email', $request->email)->first();

        $data = DB::table('users')->get();

        if ( ! $email == null ) {
            foreach ($data as $d) {
                if ($d->email == $request->email) {

                    Telegram::sendMessage([
                        'chat_id' => $d->chat_id,
                        'parse_mode' => 'HTML',
                        'text' => "<b>Pesan Reset Password</b>\n"
                                    ."Anda Dapat Melakukan reset password\n"
                                    ."dengan meng-klik button link dibawah ini\n"
                                    ."\n"
                                    ."Terima Kasih...\n"
                                    ."\n"
                                    ."<b>Jangan Membalas Pesan ini dengan perintah Apapun</b>\n",
                        'reply_markup' => Keyboard::make()
                        ->inline()
                        ->row(
                            Keyboard::inlineButton(['text' => 'Reset Password', 'url' => "http://127.0.0.1:8000/password/reset/$d->id/{{ $d->remember_token }}"])
                        )
                        ]);

                    return redirect()->route('login')->with('message', 'Permintaan Dikirim ke akun telegram anda, silahkan cek pesan reset password');

                }   
            }
        } else {
            
        return redirect()->back()->with('message', 'Data Yang Anda Berikan Tidak Benar, Masukkan Data yang Valid');

        }
    }

    public function viewResetPasswordBaru($id)
    {
        $password = User::find($id);
      
        return view('auth.passwords.reset', compact('password'));
    }

    public function resetPasswordBaru(Request $request, $id)
    {
        $reset = User::find($id);
        
        $reset->password = Hash::make($request->password);
        $reset->remember_token = $this->createNewToken();
        
        $reset->update();
    
        return redirect()->route('login')->with('message', 'Reset Password Berhasil');;
    }
}
