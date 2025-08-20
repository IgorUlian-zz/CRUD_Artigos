<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


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
    ];
    protected $casts = [
        'tags' => 'array',
    ];

    public function articles()
    {
        return $this->belongsToMany(Article::class);
    }
}
