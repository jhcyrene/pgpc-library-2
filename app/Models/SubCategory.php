<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubCategory extends Model
{
    protected $table = 'subcategories';
    public $timestamps = false;
    protected $fillable=[
        'CategoryID',
        'SubCategoryName'
    ];
}
