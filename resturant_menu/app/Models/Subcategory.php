<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subcategory extends Model
{
    use HasFactory;
    protected $fillable = ['name','category_id',"subcategory_id",'discount'];

public function subcategories()
{
    return $this->hasMany(Subcategory::class,'subcategory_id');
}
    public function items()
    {
        return $this->hasMany(item::class,'subcategory_id');
    }

public function Category()
{
    return $this->belongsTo(Category::class,'category_id');
}
    public function Subcategory()
    {
        return $this->belongsTo(Subcategory::class,'subcategory_id');
    }

}
