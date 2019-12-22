<?php
// テスト：ユーザ認証して返却する
namespace Tests\Feature;

use App\Model\Shop;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ShopLoginApiTest extends TestCase
{

    use RefreshDatabase;

    public function setUp(): void {
        parent::setUp();

        $this->shop = factory(Shop::class)->create();
    }

    /**
    * @test
    */
    public function should_店舗認証して返却する() {
        $response = $this->json('POST', route('shop.login'), [
            'email' => $this->shop->email,
            'password' => 'secret',
        ]);

        $response
            ->assertStatus(200)
            ->assertJson(['shop_name' => $this->shop->shop_name]);

            $this->assertAuthenticatedAs($this->shop);
    }
}
