<?php
/**
*  ファイルをアップロードできる
*   データベースエラーの場合はファイルを保存しない
*   ファイル保存エラーの場合はDBへの挿入はしない
*/
namespace Tests\Feature;

use App\Model\Shop;
use App\Model\Photo;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Schema;

class PhotoSubmitTest extends TestCase
{

    use RefreshDatabase;

    public function setUP(): void {
        parent::setUP();

        $this->shop=factory(Shop::class)->create();
    }

    /**
    *   @test
    */
    public function should_ファイルをアップロードできる() {
        // S3ではなく、テスト用のストレージを使用する
        // → storage/framework/testing
        Storage::fake('s3');

        $response = $this->actingAs($this->shop)
            ->json('POST', route('photo.create'), [
                // ダミーファイルを作成して送信する
                'photo' => UploadedFile::fake()->image('photo.jpeg'),
            ]);

            // レスポンスがCREATED(201)であること
            $response->assertStatus(201);

            $photo = Photo::first();

            // 写真のIDがランダムな12桁のIDランダム文字列であること
            $this->assertRegExp('/^[0-9a-zA-Z-_]{12}$/', $photo->id);

            // DBに送信されたファイル名がストレージに保存されていること
            Storage::cloud()->assertExists($photo->filename);
    }

    /**
    * @test
    */
    public function should_データベースエラーの時はファイルを保存しない() {
        // DBエラーを起こす
        Schema::drop('photos');

        Storage::fake('s3');

        $response = $this->actingAs($this->shop)
                    ->json('POST', route('photo.create'), [
                        'photo' => UploadedFile::fake()->image('photo.jpg'),
                    ]);

        // レスポンスがINTERNAL_SERVER_ERROR(500)であること
        $response->assertStatus(500);

        // ストレージにファイルが保存されていないこと
        $this->assertEquals(0, count(Storage::clould()->files()));
}
        /**
        *@test
        */
        public function should_ファイル保存エラーの場合はデータベースへの挿入はしない() {
            // ストレージをモックして保存時にエラーを起こさせる
            Storage::shouldReceive('cloud')
                ->once()
                ->andReturnNull();

                $response = $this->actingAs($this->shop)
                    ->json('POST',  route('photo.create'), [
                        'photo' => UploadedFile::fake()->image('photo.jpg'),
                    ]);

                    // レスポンスがINTERNAL_SERVER_ERROR(500)であること
                    $response->assertStatus(500);

                    $this->assertEmpty(Photo::all());
        }

}
