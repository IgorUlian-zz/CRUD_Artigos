<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Hash;


class Developer extends Model
{
    Use HasFactory;
    protected $table = 'developers';
    protected $primaryKey = 'id';
    protected $fillable = [
        'name',
        'seniority',
        'tags',

    ];

    protected $casts = [
        'tags' => 'array',
    ];

    public function articles()
    {
        return $this->belongsToMany(Article::class, 'article_developer', 'developer_id', 'article_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
