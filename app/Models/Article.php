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
    protected $fillable = ['title', 'content'];

    public function developers()
    {
        return $this->belongsToMany(Developer::class);
    }
}
