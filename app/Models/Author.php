<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
    protected $table = 'author'; 
    //protected $primaryKey = 'alter_field_as_primary_key';
    //use SoftDeletes;
    public $timestamps = false;
    use HasFactory;

    protected $fillable = ['firstname', 'lastname', 'user_id'];

    // Method of Author model
    public function books()
    {
        // the property $author->books returns an array of Books
        return $this->hasMany(Book::class,'author_id','id');
    }

    public function address()
    {
        // the property $author->address returns an object of type Address
        return $this->hasOne(Address::class,'author_id');
    }

    public function user() {
        // the property $author->user returns an object of type User
        return $this->belongsTo(User::class);
    }
}
