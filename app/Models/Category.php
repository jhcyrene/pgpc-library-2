<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\SubCategory;

class Category extends Model
{
    public $timestamps = false;
    protected $fillable=[
        'CategoryName'
    ];
    public function subcategories()
    {
        return $this->hasMany(SubCategory::class, 'CategoryID');
    }
}
