<?php

namespace App\Http\Controllers\Shop;

use App\Models\Shop;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Support\Facades\Password;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest:shop');
        // $this->shop = new Shop;
    }

    public function broker() {
        return \Password::broker('shops');
    }

    /**
     * RESET_LINK_SENTは'passwords.sent' を返している。
     */ 
    public function sendResetLinkEmail(Request $request)
    {
            
            $this->validateEmail($request);

            config()->set('auth.defaults.guard', 'shop');
            \Config::set('user', 'shop');
            \Config::set('auth.providers.users.model', \App\Model\Shop::class);


            $response = $this->broker('shops')->sendResetLink(
                $request->only('email')
            );

            return $response == Password::RESET_LINK_SENT
                                ? response()->json([
                                    'message' => 'メールを送信しました。確認してパスワードの変更を行ってください',
                                    'status' => true
                                ], 201)
                                : response()->json([
                                    'message' => '入力されたメールアドレスは登録されておりません。',
                                    'status' => false
                                ], 401);
 }
}
