<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;
    protected $table = 'events';

    // マスアサインメント可能な属性
    protected $fillable = ['user_id', 'name', 'start', 'end', 'color', 'user_id'];

    // リレーションシップの定義（必要に応じて）
    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
