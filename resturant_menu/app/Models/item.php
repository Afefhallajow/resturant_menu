<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class item extends Model
{
    use HasFactory;

    protected $fillable = ['name','price',"subcategory_id",'discount'];



    public function subcategory()
    {
        return $this->belongsTo(Subcategory::class,'subcategory_id');
    }

}
