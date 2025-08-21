<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Article extends Model
{
    //
    Use HasFactory;
    protected $table = 'articles';
    protected $primaryKey = 'id';
    protected $fillable = [
        'title',
        'slug',
        'image',
        'html_file',

    ];
    protected $hidden = [''];


    public function developers()
    {
        return $this->belongsToMany(Developer::class, 'article_developer', 'article_id', 'developer_id');
    }
}
