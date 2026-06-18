<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    //protected $table = 'my_book_table';//kapag iba ang name ng table Class(Book),table(tblbook)
    public $timestamps = false;
    protected $fillable=[
        'BookID','ISBN','BookTitle','DatePublished','Author','Publisher','Category','SubCategory','Status'
    ];
}
