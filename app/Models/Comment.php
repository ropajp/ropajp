<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    /**
    * JSONに含める属性
    */
    protected $visible = [
        'author', 'content', 'created_at',
    ];

    /**
    * リレーション - shopsテーブル
    * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
    */
    public function author() {
        return $this->belongsTo('App\Models\User', 'user_id', 'id','users');
    }
}
