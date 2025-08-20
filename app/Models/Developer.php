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
        'email',
        'password',
        'seniority',
        'tags',
    ];

    protected $hidden = [
    'password',
    ];

    protected $casts = [
        'tags' => 'array',
    ];

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = Hash::make($value);
    }

    public function articles()
    {
        return $this->belongsToMany(Article::class, 'developer_article', 'developer_id', 'article_id');
    }
}
