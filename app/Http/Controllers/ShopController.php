<?php
/***************************
**      店舗一覧取得API          **
**    店舗詳細情報取得API    **
**             お気に入りAPI        **
***************************/

namespace App\Http\Controllers;

use App\Models\Shop;
use App\Model\User;
use App\Models\Photo;
use App\Models\Comment;
use App\Http\Requests\StoreSearchKey;
use App\Http\Requests\StoreComment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ShopController extends Controller
{
    /**
    * 店舗一覧API
    * @params array $request
    * @param StoreSearchKey $request
    * @return $shops
    */
    public function select(StoreSearchKey $request)
    {

        /**
        * リクエストされた値を格納
        * @var string
        */
        $key = $request->key;

        /**
        * 店舗一覧取得ORM
        * テーブル - shops
        * リレーション - photos
        */
        // 受け取った値が$allまたは空欄なら
        if($key === '$all' || $key === '') {
            // 全権取得
            $shops = Shop::with(['photos' => function($query) {
                        $query->where('cover_photo_flg', 1);
            }, 'favorites'])->paginate();

        // もし送信された値の文字数が0以上なら
        } else if (strlen($key) > 0) {
                // 全角スペースを半角スペースに変換
                $replaceKey = str_replace("　", " ", $key);
                // 両端にある空白を削除
                $trimKey = trim($replaceKey);
                // スペースで分割し配列に格納
                $arrayKeys = explode(" ", $trimKey);

            // リクエストされた値があるレコードを取得
            $shops = Shop::with(['photos' => function($query) {
                        $query->first();
                }, 'favorites'])
            ->where(function($query) use ($arrayKeys) {
                foreach($arrayKeys as $arrayKey) {
                    $query->orWhere('shops.name', 'like', "%{$arrayKey}%")
                          ->orWhere('shops.state', 'like', "%{$arrayKey}%")
                          ->orWhere('shops.city', 'like', "%{$arrayKey}%")
                        //  ->orWhere('shops.town_street', 'like', "%{$arrayKey}%")
                          ->orWhere('shops.category', 'like', "%{$arrayKey}%")
                           ->orWhere('shops.brands', 'like', "%{$arrayKey}%")
                          ->orWhere('shops.gender_for', 'like', "%{$arrayKey}%")
                          ->orWhere('shops.shop_detail', 'like', "%{$arrayKey}%");
                }
            })->paginate();
        }

        // 店舗情報を返す
        return response()->json($shops);
    }

    /**
    * 店舗詳細
    * @param string $id
    * @return Shop
    */
    public function show(string $id)
    {
        // idをキーに店舗詳細を取得
        $shop = Shop::with(['photos', 'comments.author', 'favorites'])->where('id', $id)->first();
        // 店舗情報を返す　店舗が見つからなかったら404(UNPROCESSABLE_ENTITY)を返す
        return $shop ?? abort(404);
    }

    /**
    * コメント投稿
    * @param Shop $shop
    * @param StoreComment $request
    * @return \Illuminate\Http\Response
    */
    public function addComment(Shop $shop, StoreComment $request)
    {
        // コメントインスタンスを生成
        $comment = new Comment();
        // リクエストされたコメントを格納
        $comment->content = $request->get('content');
        // コメントを店舗idと店舗Idを紐付け
        $comment->user_id = Auth::user()->id;
        // commentsテーブルにインサート
        $shop->comments()->save($comment);

        // authorリレーションをロードするためにコメントを取得し直す
        $new_comment = Comment::where('id', $comment->id)->with('author')->first();
        // ロードしたコメントを返す
        return response($new_comment, 201);
    }

    /**
    * お気に入り
    * @param string $id
    * @return array
    */
    public function favorite(string $id)
    {
        // いいねをする対象の店舗を$shopに格納
        $shop = Shop::where('id', $id)->with('favorites')->first();

        // もし$shop以外なら
        if(! $shop) {
            // 404を返す
            abort(404);
        }

        // 一回しかいいねがつかないように最初にいいね削除
        $shop->favorites()->detach(Auth::user()->id);
        // いいねする
        $shop->favorites()->attach(Auth::user()->id);
        // フロントでidによるお気に入り管理を行うためshop_idを返す
        return ["shop_id" => $id];
    }

    /**
    * お気に入り解除
    * @param string $id
    * @return array
    */
    public function unfavorite(string $id)
    {
        // いいねを削除する対象の店舗を$shopに格納
        $shop = Shop::where('id', $id)->with('favorites')->first();

        if(! $shop) {
            abort(404);
        }

        $shop->favorites()->detach(Auth::user()->id);
        // 店舗idを返す
        return ["shop_id" => $id];
    }

}
