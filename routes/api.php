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

// ***************************************************************************************************
// 一般ユーザグループ - 認証
// 一般ユーザ新規登録
// 一般ユーザログイン
// 一般ユーザログアウト
// 一般ユーザのパスワードリセット用リンク送信
// 一般ユーザのパスワードリセット実行
// ***************************************************************************************************
Route::namespace('Auth')->group(function(){
    // 一般ユーザ新規登録
    Route::post('/register', 'RegisterController@register')->name('register');
    // 一般ユーザログイン
    Route::post('/login', 'LoginController@login')->name('login');
    // 一般ユーザログアウト
    Route::post('/logout', 'LoginController@logout')->name('logout');
    // パスワードリセット用リンク送信
    Route::post('/password/email', 'ForgotPasswordController@sendResetLinkEmail')->name('password.email');
    // パスワードリセット実行
    Route::post('/password/reset', 'ResetPasswordController@reset')->name('password.reset');
});

// 一般ユーザがログイン中かチェック
Route::get('/user', function() {
    return Auth::user();
})->name('user');


// ***************************************************************************************************
// ＜写真設定画面グループ＞
// 写真アップロード
// 写真削除
// 写真一覧取得
// カバー写真登録（検索時一番上に表示される写真）
// ***************************************************************************************************
Route::prefix('/owners/setting/photos')->name('shop.photo.')->group(function() {
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


// ***************************************************************************************************
// 写真以外の店舗設定変更画面グループ
// （写真は変更以外にも特殊なロジックが含まれるため別グループとした。）
// 店舗名、店舗情報更新画面
// 住所変更画面
// 店舗詳細画面
// ***************************************************************************************************
Route::namespace('Shop\Setting')->prefix('/owners/setting')->name('shop.setting.')->group(function() {
    // 店舗名、電話番号情報取得表示
    Route::get('namePhone/select/{id}', 'NamePhoneController@index')->name('namePhone.select');
    // 店舗名、電話番号更新
    Route::post('namePhone/update', 'NamePhoneController@update')->name('namePhone.update');
    // 住所情報取得表示
    Route::get('address/select/{id}', 'AddressController@index')->name('address.select');
    // 住所情報更新
    Route::post('address/update', 'AddressController@update')->name('address.update');
    // 店舗詳細情報(カテゴリー、取扱ブランド、対象性別、店舗説明文)取得表示
    Route::get('detail/select/{id}', 'DetailController@index')->name('detail.select');
    // 店舗詳細情報(カテゴリー、取扱ブランド、対象性別、店舗説明文)更新
    Route::post('detail/update', 'DetailController@update')->name('detail.update');
    // 営業情報取得表示
    Route::get('workdays/select/{id}', 'WorkdaysController@index')->name('workdays.select');
    // 営業情報更新
    Route::post('workdays/update', 'WorkdaysController@update')->name('workdays.update');
});



// ***************************************************************************************************
// ＜店舗機能各種グループ＞
// コメント追加
// お気に入り追加
// お気に入り削除
// ***************************************************************************************************
Route::prefix('shops')->name('shop.')->group(function() {
    // 店舗詳細表示
    Route::get('/{id}', 'ShopController@show')->name('show');
    // コメント
    Route::post('/{shop}/comments', 'ShopController@addComment')->name('comment');
    // いいね
    Route::put('/{id}/favorite', 'ShopController@favorite')->name('favorite');
    // いいね解除
    Route::delete('/{id}/favorite', 'ShopController@unfavorite');
});


// ***************************************************************************************************
// 認証系店舗ユーザグループ -  認証
// ***************************************************************************************************
Route::namespace('Shop')->prefix('owners')->name('shop.')->group(function() {
    // 店舗新規登録
    Route::post('/ownerRegister', 'RegisterController@register')->name('register');
    // 店舗ログイン
    Route::post('/ownerLogin', 'LoginController@login')->name('login');
    // 店舗ログアウト
    Route::post('/ownerLogout', 'LoginController@logout')->name('logout');
    // 店舗パスワードリセット
    Route::post('/ownerPassword/email', 'ForgotPasswordController@sendResetLinkEmail')->name('password.email');
    // パスワードリセット実行
    Route::post('/ownerPassword/reset', 'ResetPasswordController@reset')->name('password.reset');
});

// 店舗ユーザがログイン中かどうかチェック
Route::get('/owners', 'Shop\LoginController@me')->name('owner');

// トークンリフレッシュ
Route::get('/refresh-token', function(Illuminate\Http\Request $request) {
    $request->session()->regenerateToken();

    return response()->json();
});

