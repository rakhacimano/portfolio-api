<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'comments';

    protected $fillable = [
        'article_id',
        'content',
    ];

    public function article()
    {
        return $this->belongsTo(Article::class, 'article_id');
    }
}
