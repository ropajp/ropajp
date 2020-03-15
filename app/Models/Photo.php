<?php
namespace App\Models;

use App\Models\Shop;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Arr;

class Photo extends Model
{
    /* JSONに含める属性 */
    protected $appends = [
        'url',
    ];
    /* JSONに含める属性 */
    protected $visible = [
        'id', 'url', 'cover_photo_flg',
    ];

    /**
    *   アクセスメソッド - url - S3上のファイル公開URLを返す
    *   AWS_URLと引数のファイル名を結合した値
    *   Illuminate\Support\Facades\Storage
    *   @return string
    */
    public function getUrlAttribute() {
        return Storage::cloud()->url($this->attributes['filename']);
    }

    /** プライマリキーの型 */
    protected $keyType = 'string';
    /** IDの桁数 */
    const ID_LENGTH = 12;
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        if (! Arr::get($this->attributes, 'id')) {
            $this->setId();
        }
    }
    /**
     * ランダムなID値をid属性に代入する
     */
    private function setId()
    {
        $this->attributes['id'] = $this->getRandomId();
    }
    /**
     * ランダムなID値を生成する
     * @return string
     */
    private function getRandomId()
    {
        $characters = array_merge(
            range(0, 9), range('a', 'z'),
            range('A', 'Z'), ['-', '_']
        );
        $length = count($characters);
        $id = "";
        for ($i = 0; $i < self::ID_LENGTH; $i++) {
            $id .= $characters[random_int(0, $length - 1)];
        }
        return $id;
    }

}
