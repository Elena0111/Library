<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $table = 'address'; 
    public $timestamps = false;
    use HasFactory;

    protected $fillable = ['street_and_number', 'city', 'province', 'country', 'postcode', 'author_id'];

    // Method of Address model
    public function author()
    {
        // the property $address->author returns an object of type Author
        return $this->belongsTo(Author::class,'author_id');
    }
}
