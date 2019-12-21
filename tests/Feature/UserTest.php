<?php
//新規登録テスト
namespace Tests\Feature;

use App\Model\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    use RefreshDatabase;

/**
*@test
*/
public function should_新しいユーザを作成して返却する() {
//テスト用データ
    $data = [
        'name' => 'Shingo',
        'email' => 'aaaa@gmail.com',
        'password' => 'aaaaaaaa',
        'password_confirmation' => 'aaaaaaaa',
    ];

    $response = $this->json('POST', route('register'), $data);

    $user = User::first();
// 入力したデータが返ってきた値と同値であること
    $this->assertEquals($data['name'], $user->name);

    $response->assertStatus(201)
                ->assertJson([
                    'name' => $user->name
                ]);
    }
}
