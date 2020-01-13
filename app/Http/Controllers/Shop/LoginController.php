<?php
/******************************
**          店舗ログインAPI             **
******************************/
namespace App\Http\Controllers\Shop;

use Illuminate\Support\Facades\Session;
use App\Models\Shop;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use JWTAuthException;
use JWTAuth;
use Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

   use AuthenticatesUsers;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
     public function __construct()
    {
        $this->middleware('guest:shop');
        // Shopインスタンスを生成
        $this->shop = new Shop;
    }

        /**
        * 認証処理をする。
        * @return response
        */
        function  login(Request $request) {
            // 入力文字のバリデーション
            $validator = Validator::make($request->all(), [
                'email' => 'required|string|email|max:255',
                'password'=> 'required|min:8'
            ]);

            // 入力された値を取得
            $email = $request->email;
            $password = $request->password;

// 認証設定の定義
            config()->set('auth.defaults.guard', 'shop');
            \Config::set('jwt.user', 'shop');
            \Config::set('auth.providers.users.model', \App\Model\Shop::class);

            // 下のAuth::attemptは配列を引数として受け取るため配列にする
                $credentials = array(
                    'email' => $email,
                    'password' => $password,
                );

                try {
                    // もし認証と一致しないなら
                    if(! $token = Auth::attempt($credentials)) {
                        // 422エラーをjsonで返す
                        return response()->json(['message' => 'The given data was invalid.',
                                                 'errors' => [
                                                              'email' => ['認証情報が記録と一致しません。']
                                                ],], 422);
                    }

                } catch(JWTAuthException $e) {
                    // 例外発生時ステータス401をjsonで返す
                    return response()->json(['error' => 'could_not_create_token'], 401);
                }
                // 店舗情報を取得
                $shop = Shop::with(['photos', 'favorites'])->where('email', $email)->first();

                // セッションに保存
                session(['shop' => $shop]);
                // 取得した情報を返す
                return response()->json($shop);
            }
// 店舗ログインチェック - セッション
        public function me(Session $session) {
            // もし店舗がセッションにあるなら   
            if(Auth::guard('shop')->check()) {
                // セッションから店舗情報を取得
                $session = Session::get('shop');
                // 取得した情報を返す
                return response()->json($session);
                }
            }
// ログアウト
            public function logout(Request $request)
            {
                // ログアウト実行
                $this->guard('shop')->logout();
                // 現在のセッションを無効にする
                $request->session()->invalidate();
                // 下のloggedOutファンクションを返す
                return $this->loggedOut($request);
            }

// logoutファンクションで呼ばれる
                protected function loggedOut(Request $request)
                {
                    // セッションを再生成する
                    $request->session()->regenerate();
                    // レスポンスをjsonで返す
                    return response()->json();
                }

}
