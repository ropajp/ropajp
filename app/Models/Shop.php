<?php

namespace App\Models;

use App\Models\Photo;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Notifications\OwnerResetPassword;

class Shop extends Authenticatable implements JWTSubject
{
    use Notifiable;

    // user以外のモデルを使うため必要
    protected $guard = 'shop';

    protected $table = 'shops';
    // 1ページあたりの表示件数
    protected $perPage = 12;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'phone_number', 'url', 'postcode', 'state', 'city', 'town_street', 'brands', 'open_at',  'close_at', 'day_off', 'category', 'gender_for', 'shop_detail',
    ];

    /**
    * JSONに含める属性
    */
    protected $appends = [
        'favorites_count', 'favorite_by_user',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     * JSONに含めない属性
     */
     protected $hidden = [
         'email_verified_at', 'password',
        'remember_token', 'created_at', 'updated_at', 'deleted_at', 'favorites',
     ];
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
    * アクセサ - favorites_count
    * @return int
    */
    // いいね数を返す
    public function getFavoritesCountAttribute()
    {
        return $this->favorites->count();
    }

    /**
    * アクセサ - favorite_by_user
    * @return boolean
    */
    // いいねをしたユーザidを返す
    public function getFavoriteByUserAttribute()
    {
        // もしログインユーザでないなら
        if(Auth::guest()) {
            // 何も返さない
            return false;
        }

        // favoritesを含んだユーザidを返す
        return $this->favorites->contains(function($user) {
            return $user->id === Auth::user()->id;
        });
    }

    /**
    * リレーション - photosテーブル
    * @return \Illuminate\Database\Eloquent\Relations\HasMany
    */
    public function photos()
    {
        return $this->hasMany('App\Models\Photo')->orderBy('cover_photo_flg', 'desc');
    }

    /**
    * リレーション - commentsテーブル
    * @return \Illuminate\Database\Eloqurnt\Relations\HasMany
    */
    public function comments()
    {
        return $this->hasMany('App\Models\Comment')->orderBy('id', 'desc');
    }

    /**
    * リレーション - usersテーブル
    * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
    */
    public function favorites()
    {
        return $this->belongsToMany('App\Models\User', 'favorites')->withTimestamps();
    }

// 　JWTを実装する際に必ず以下の２つのメソッドが必要。
    public function getJWTIdentifier()
   {
        return $this->getKey();
    }
        public function getJWTCustomClaims()
   {
        return [];
    }

    /**
     * パスワード再設定メールの送信
     * 
     * @param string $token
     * @return void
     */ 
     public function sendPasswordResetNotification($token) 
     {
        $this->notify(new OwnerResetPassword($token));
     }
}
