<?php
// ショップ登録テスト
namespace Tests\Feature;

use App\Model\Shop;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ShopRegisterApiTest extends TestCase
{
    use RefreshDatabase;

    /**
    * @test
    */
    public function should_新しい店舗を追加して返却する() {

        $data = [
                'name' => 'Norris Brakus PhD',
                'email' => 'ropa@example.com',
                'password' => 'aaaaaaaa',
                'password_confirmation' => 'aaaaaaaa',
                'phone_number' => '09000000000',
                'postcode' => '12345678',
                'state' => '東京',
                'city' => '新宿',
                'town_street' => '新宿ビル5-23-4',
                'category' => 'カジュアル',
                'gender_for' => '男性',
                'shop_detail' => 'カジュアルなお店です。' ,
        ];

        $response = $this->json('POST', route('shop.register'), $data);

        $shop = Shop::first();

      $this->assertEquals($data['name'], $shop->name);

        $response->assertStatus(201)
                    ->assertJson([
                        'name' => $shop->name
                ]);
    }
}
