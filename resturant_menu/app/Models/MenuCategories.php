<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MenuCategories extends Model
{
    use HasFactory;
    public function category()
    {
        return $this->belongsTo(Subcategory::class,'category_id');
    }

}
