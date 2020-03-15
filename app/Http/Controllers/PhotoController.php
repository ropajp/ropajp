<?php
namespace App\Http\Controllers;

use App\Http\Requests\StorePhoto;
use App\Models\Shop;
use App\Models\Photo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class PhotoController extends Controller
{
    public function __construct() {
        // 認証が必要
        $this->middleware('auth:shop')->except(['index']);
    }

    public function select(Request $request) {
        $shops = Shop::with('photos')->where('id', $request->id)->first() ?? '';
        return $shops;
    }

    /**
    * 写真投稿
    * @param StorePhoto $request
    * @return \Illuminate\Http\Response
    */
    public function create(StorePhoto $request) {
        // 写真投稿拡張子を取得する
        $extension = $request->photo->extension();

        $photo = new Photo();
        
        // インスタンス生成時に割り振られたランダムなIDと本来の拡張子を組み合わせてファイル名とする
        $photo->filename = $photo->id . '.' . $extension;

        // S3にファイルを保存する。
        // 第三引数の'public' はファイルを公開状態で保存するため。
        Storage::cloud()->putFileAs('', $request->photo, $photo->filename, 'public');

        // トランザクション開始 - DBエラー時にファイル削除を行うため
        DB::beginTransaction();

        try {
            // 認証して写真を保存
            Auth::user()->photos()->save($photo);
            // コミット
            DB::commit();
            // 例外発生時
        } catch(\Exception $exception) {
            // ロールバック
            DB::rollback();
            // DBとの不整合を避けるためアップロードしたファイルを削除
            Storage::cloud()->delete($photo->filename);
            throw $exception;
        }
        // リソースの新規作成なので、
        // レスポンスコードは201(CREATED)を返却する
        $shops = Shop::with('photos')->where('id', $request->id)->first();

        // 店舗IDに紐づく写真の数をカウント
        $count = $shops->photos()->count();
        // もし写真が一枚だけ(一番最初の写真なら)
        if($count === 1) {
            // トランザクション開始
            DB::beginTransaction();
            try {
                // カバー写真のフラグを立てる
                $shops->photos()->update(['cover_photo_flg' => 1]);
                // コミット
                DB::commit();
            } catch(\Exception $exception) {
                // ロールバック
                DB::rollback();
                throw $exception;
            }
        }

        // フロント側に店舗情報を返す
        return response()->json([
                        'shop' =>$shops,
                        'status' => 201
                    ]);
    }
    /**
    * 写真削除
    * @param Request - Array
    * @return $shop
    */
    public function delete(Request $request)
    {
        // トランザクション開始
        DB::beginTransaction();
        try {
            // 配列の値を削除
            Photo::destroy($request->arr);
            //  S3のストレージから削除
            Storage::cloud()->delete($request->arr);
            // コミット
            DB::commit();
            // 例外発生時
        } catch(\Exception $exception) {
            // ロールバック
            DB::rollback();
            throw $exception;
        }
        // 店舗情報を返す
        $shops = Shop::with('photos')->where('id', $request->id)->first();
        return $shops;
     }

     /**
     * カバー写真登録
     * @params $request
     * @return
     */
     public function cover(Request $request)
     {
         // トランザクション開始
         DB::beginTransaction();
         try {
            // 最初に写真のカバーフラグを全て0にする
            Photo::where('shop_id', $request->id)
                    ->update(['cover_photo_flg' => 0]);
            // 選択された写真にカバーフラグを立てる
            Photo::where('id', $request->photo)
                    ->update(['cover_photo_flg' => 1]);

             // コミット
             DB::commit();
             // 例外発生時
         } catch(\Exception $exception) {
             // ロールバック
             DB::rollback();
             throw $exception;
         }
         // 店舗情報を返す
         $shops = Shop::with('photos')->where('id', $request->id)->first();
         return $shops;
     }
}
