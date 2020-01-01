<?php
use Illuminate\Http\Request;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// 一般ユーザグループ - 未認証
Route::namespace('Auth')->group(function(){
// 一般ユーザ新規登録
Route::post('/register', 'RegisterController@register')->name('register');
// 一般ユーザログイン
Route::post('/login', 'LoginController@login')->name('login');
// 一般ユーザログアウト
Route::post('/logout', 'LoginController@logout')->name('logout');
// パスワードリセット
Route::post('/password/email', 'ForgotPasswordController@sendResetLinkEmail')->name('password.reset');
});
// 一般ユーザがログイン中かチェック
Route::get('/user', function() {
    return Auth::user();
})->name('user');

// 写真設定画面グループ
Route::prefix('/owners/setting/photos')->name('photo')->group(function() {
// 写真アップロード
Route::post('/add/{id}', 'PhotoController@create')->name('create');
// 写真削除
Route::delete('/eliminate', 'PhotoController@delete')->name('delete');
//  写真一覧取得
Route::get('/select/{id}', 'PhotoController@select')->name('select');
// カバー写真登録
Route::post('/cover', 'PhotoController@cover')->name('cover');
});
// 店舗検索
Route::get('/shop-list/{key}', 'ShopController@select')->name('shop.select');

// 店舗機能各種グループ - コメント、お気に入り追加、お気に入り削除
Route::prefix('shops')->name('shop')->group(function() {
    // 店舗詳細表示
    Route::get('/{id}', 'ShopController@show')->name('show');
    // コメント
    Route::post('/{shop}/comments', 'ShopController@addComment')->name('comment');
    // いいね
    Route::put('/{id}/favorite', 'ShopController@favorite')->name('favorite');
    // いいね解除
    Route::delete('/{id}/favorite', 'ShopController@unfavorite');
});

// 未登録店舗ユーザグループ -  未認証
Route::namespace('Shop')->prefix('owners')->name('shop')->group(function() {
    // 店舗新規登録
    Route::post('/ownerRegister', 'RegisterController@register')->name('register');
    // 店舗ログイン
    Route::post('/ownerLogin', 'LoginController@login')->name('login');
    // 店舗ログアウト
    Route::post('/ownerLogout', 'LoginController@logout')->name('logout');
    // 店舗パスワードリセット
    Route::post('/ownerPassword/email', 'ForgotPasswordController@sendResetLinkEmail')->name('password.reset');
});

// 店舗ユーザがログイン中かどうかチェック
Route::get('/owners', 'Shop\LoginController@me')->name('owner');

// トークンリフレッシュ
Route::get('/refresh-token', function(Illuminate\Http\Request $request) {
    $request->session()->regenerateToken();

    return response()->json();
});

