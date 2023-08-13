<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class News extends Model
{
    use HasFactory;

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public static function createNews(array $data)
    {
        $news = new self;
        $news->user_id      = $data['user_id'];
        $news->title        = $data['title'];
        $news->content      = $data['content'];
        $news->image_url    = $data['saved_image_url'];
        $news->save();
    }

    public static function editNews(array $data)
    {
        $news = self::find($data['id']);
        $news->user_id      = $news->user_id;
        $news->title        = $data['title'];
        $news->content      = $data['content'];
        $news->image_url    = $news->image_url;
        $news->save();
    }

    public static function deleteNews(string $id): string
    {
        $news = self::find($id);
        $imageUrl = $news->image_url;
        $news->delete();

        return $imageUrl;
    }
}
