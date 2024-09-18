<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'category'; 
    public $timestamps = false;

    protected $fillable = ['name'];

    // Method of Category model
    public function books()
    {
        // the property $category->books returns an array of Book
        return $this->belongsToMany(Book::class,'book_category','category_id','book_id');
    }
}
