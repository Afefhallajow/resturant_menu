<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $fillable = ['name','discount',"menu_id"];
    public function menu()
    {
        return $this->belongsTo(Menu::class,'menu_id');
    }

    public function subcategories()
    {
        return $this->hasMany(Subcategory::class,'category_id');
    }

}

