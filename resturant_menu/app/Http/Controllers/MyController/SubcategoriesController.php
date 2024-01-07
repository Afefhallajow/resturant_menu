<?php

namespace App\Http\Controllers\MyController;

use App\Http\Controllers\CheckToAdd;
use App\Http\Controllers\Controller;
use App\Http\Controllers\ResponseFunction;
use App\Models\Category;
use App\Models\Subcategory;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class SubcategoriesController extends Controller
{use ResponseFunction,CheckToAdd ;
/**
* Display a listing of the resource.
*/
public function index()
{
    try {


        $subcategories = Subcategory::all();
        return $this->success($subcategories, 'done');
    }catch (\Exception $exceptione){
return $this->error($exceptione->getMessage())
;}
}

/**
* Show the form for creating a new resource.
*/
public function create()
{
//
}

/**
* Store a newly created resource in storage.
*/
public function store(Request $request)
{
try {


return DB::transaction(function() {
$rules = [
'name' => 'required|string|max:255',
];
$error = Validator::make(request()->all(), $rules);
if ($error->fails()) {
return response()->json(['data' => $error->errors()->all()]);
}
$name = request()->name;
$category_id = request()->category_id;
if ($category_id)
{
$category = Category::where('id', $category_id)->first();
if ($category) {
if (true) {
$number_of_subcategories = $category->number_of_subcategories + 1;
$category->update(['number_of_subcategories' => $number_of_subcategories]);
if (request()->discount)
$discount=request()->discount;
else
$discount=0;

Subcategory::create(['name' => $name,
"category_id" => $category_id,"discount"=>$discount]);

return $this->success([], "created done",201);

} else {
return $this->error("your category already have 4 subcategories ");
}


} else {
return $this->error("category not found",404);
}

}
/*** if you want to implemnt subcategories with another subcategories ***/
elseif(request()->subcategory_id)
{
$subcategory_id=\request()->subcategory_id;
if($subcategory_id)
$subcategory = SubCategory::where('id', $subcategory_id)->first();
if ($subcategory) {
if($this->checkTheLevel($subcategory,new Subcategory())) {
    if( $this->IfCanAddsubcategory($subcategory)) {

        if (request()->discount)
            $discount = request()->discount;
        else
            $discount = 0;

        Subcategory::create(['name' => $name,
            "subcategory_id" => $subcategory_id, 'discount' => $discount]);

        return $this->success([], "created done");
    }else{
        return $this->error("subcategory contain items ");

    }

}else{
return $this->error("subcategory level more than 4 ");

}
} else {
return $this->error("subcategory not found");
}

}
else{    return $this->error("you should put category or subcategory");
}
}
);}
catch (\Exception $e)

{return $this->error($e->getMessage());}


}

/**
* Display the specified resource.
*/
public function show(string $id)
{
try {
return           DB::transaction(function ()use ($id){
$subcategory=Subcategory::where("id",$id)->first();
if($subcategory)
{$temp=Array();

$temp=["subcategory"=>$subcategory,"items"=>$subcategory->items,"subcategories"=>$subcategory->subcategories];
return $this->success($temp,"done");

}else
return $this->error("Subcategory not found");

});



}catch (\Exception $e)
{
return $this->error($e->getMessage());
}





}

/**
* Show the form for editing the specified resource.
*/
public function edit(string $id)
{


}

/**
* Update the specified resource in storage.
*/
public function update(Request $request, string $id)
{



try {


return DB::transaction(function() use($id) {
$subcategory1=Subcategory::where('id',$id)->first();
if ($subcategory1) {
$rules = [
'name' => 'required|string|max:255',
];
$error = Validator::make(request()->all(), $rules);
if ($error->fails()) {
return response()->json(['data' => $error->errors()->all()]);
}
$name = request()->name;
$category_id = request()->category_id;
if ($category_id) {
$category = Category::where('id', $category_id)->first();
if ($category) {
if (true) {
if (request()->discount)
$discount=request()->discount;
else
$discount=$subcategory1->discount;


$subcategory1->update(["name"=>$name,"category_id"=>$category_id,"subcategory_id"=>null,'discount'=>$discount]);
return $this->success([], "created done");

} else {
return $this->error(" ");
}


} else {
return $this->error("category not found");
}

} /*** if you want to implemnt subcategories with another subcategories ***/
elseif (request()->subcategory_id) {
$subcategory_id = \request()->subcategory_id;
if ($subcategory_id)
$subcategory = SubCategory::where('id', $subcategory_id)->first();
if ($subcategory) {
if ($this->checkTheLevel($subcategory,$subcategory1) ) {
if( $this->IfCanAddsubcategory($subcategory)) {
if (request()->discount)
$discount = request()->discount;
else
$discount = $subcategory1->discount;

$subcategory1->update(['name' => $name,
"subcategory_id" => $subcategory_id, 'category_id' => null, "discount" => $discount]);

return $this->success([], "updated done");
}
else {
return $this->error("subcategory contain Items ");
}
}else{
return $this->error("subcategories level more than 4 ");

}

} else {
return $this->error("subcategory not found");
}

} else {
return $this->error("you should put category or subcategory");
}

}else{
return $this->error('subcategory not found');
}

}
);}
catch (\Exception $e)

{return $this->error($e->getMessage());}






}

/**
* Remove the specified resource from storage.
*/
public function destroy(string $id)
{
try {
return DB::transaction(function () use ($id){
$subcategory=Subcategory::where("id",$id)->first();
if($subcategory) {

$subcategory->delete();
return $this->success($subcategory, "delete done");
}else
{return $this->error("subcategory not found");}

});
}
catch (\Exception $e)
{return $this->error($e->getMessage());}
}
}
