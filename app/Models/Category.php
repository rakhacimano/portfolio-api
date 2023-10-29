<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'categories';

    protected $fillable = [
        'name',
    ];

    public function articles()
    {
        return $this->hasMany(Article::class, 'category_id');
    }

    public function portfolios()
    {
        return $this->hasMany(Portfolio::class, 'category_id');
    }
}
