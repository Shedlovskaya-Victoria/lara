<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $guarded = [];
    use HasFactory;

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

    public function category(){
        return $this->belongsTo(Category::class);
    }
    public  function tags(){
        return $this->belongsToMany(Tag::class)->as('tags');
    }
}
