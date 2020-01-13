<?php

namespace App\Http\Controllers\Shop\Setting;

use App\Models\Shop;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class NamePhoneController extends Controller
{
    // 認証が必要
    public function __construct() 
    {   
        $this->middleware('auth:shop');
    }
    
    public function select($id) {
        $shop = Shop::select(['name', 'phone_number'])->where('id', $id)->first();
        return $shop;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {   
        $id = $request->id;
        $sqlResult = $this->select($id);
        return $sqlResult;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Shop  $shop
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {   
        // 店舗ID格納
        $id = $request->id;

        // トランザクション開始
        DB::beginTransaction();

        try {
            // UPDATE実行
            Shop::where('id', $id)->update([
                'name' => $request->form['name'],
                'phone_number' => $request->form['phone_number'],
            ]);
            // コミット実行
            DB::commit();
            // 例外発生時
        } catch(\Exception $exception) {
            // ロールバック
            DB::rollback();
            throw $exception;
        }
            $sqlResult = $this->select($id);
            return response()->json([
                'shop' => $sqlResult,
                'status' => 200,
            ]);
    }
}
