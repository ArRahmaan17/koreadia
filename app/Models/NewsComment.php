<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class NewsComment extends Model
{
    use HasFactory;

    protected $with = ['comment_user'];

    protected $fillable = [
        'news_id',
        'comment',
        'user_id',
    ];

    public static function Comment($slug, $data)
    {
        $news = News::where('slug', $slug)->first();
        $data['news_id'] = $news->id;

        return self::create($data);
    }

    public function comment_user(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
