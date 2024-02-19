<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *      schema="Post",
 *      required={"title","description","image","slug","category_id"},
 *      @OA\Property(
 *          property="title",
 *          description="",
 *          readOnly=false,
 *          nullable=false,
 *          type="string",
 *      ),
 *      @OA\Property(
 *          property="description",
 *          description="",
 *          readOnly=false,
 *          nullable=false,
 *          type="string",
 *      ),
 *      @OA\Property(
 *          property="image",
 *          description="",
 *          readOnly=false,
 *          nullable=false,
 *          type="string",
 *      ),
 *      @OA\Property(
 *          property="slug",
 *          description="",
 *          readOnly=false,
 *          nullable=false,
 *          type="string",
 *      ),
 *      @OA\Property(
 *          property="created_at",
 *          description="",
 *          readOnly=true,
 *          nullable=true,
 *          type="string",
 *          format="date-time"
 *      ),
 *      @OA\Property(
 *          property="updated_at",
 *          description="",
 *          readOnly=true,
 *          nullable=true,
 *          type="string",
 *          format="date-time"
 *      )
 * )
 */
class Post extends Model
{
    public $table = 'posts';

    public $fillable = [
        'title',
        'description',
        'image',
        'slug',
        'category_id'
    ];

    protected $casts = [
        'title' => 'string',
        'description' => 'string',
        'image' => 'string',
        'slug' => 'string'
    ];

    public static array $rules = [
        'title' => 'required|string|max:255',
        'description' => 'required|string|max:255',
        'image' => 'required|string|max:255',
        'slug' => 'required|string|max:255',
        'category_id' => 'required',
        'created_at' => 'nullable',
        'updated_at' => 'nullable'
    ];

    public function category(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(\App\Models\Category::class, 'category_id');
    }

    public  function tags(){
        return $this->belongsToMany(Tag::class)->as('tags');
    }
    public function postTags(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(\App\Models\PostTag::class, 'post_id');
    }
    public function calculateReadingTime($text, $wordsPerMinute = 120)
    {
        // Разделяем текст на отдельные слова
        $word_count = count(
            preg_split('/\W+/u', $text, -1, PREG_SPLIT_NO_EMPTY)
        );
        // Вычисляем ориентировочное время чтения
        $minutes = floor($word_count / $wordsPerMinute);
        $seconds = floor(
            $word_count % $wordsPerMinute / ($wordsPerMinute / 60)
        );
        $str_minutes = ($minutes == 1) ? "мин." : "мин.";
        $str_seconds = ($seconds == 1) ? "сек." : "сек.";
        $readingTime = '';
        if ($minutes == 0) {
            $readingTime .= "$seconds $str_seconds";
        } else {
            $readingTime .= "$minutes $str_minutes $seconds $str_seconds";
        }
        return $readingTime;
    }
}
