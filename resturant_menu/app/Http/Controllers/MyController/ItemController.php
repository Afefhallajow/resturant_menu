<?php

namespace App\Http\Controllers\MyController;

use App\Http\Controllers\CheckToAdd;
use App\Http\Controllers\Controller;
use App\Http\Controllers\ResponseFunction;
use App\Http\Resources\itemResource;
use App\Models\Category;
use App\Models\item;
use App\Models\Subcategory;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ItemController extends Controller
{use ResponseFunction ,CheckToAdd;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {


            $items = item::all();
            return response()->json(['message' => 'done', 'data' => itemResource::collection($items), 'success' => true], 200);
        }catch (\Exception $exception)
        {return  $this->error($exception->getMessage());}
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
                    'price'=>'required|max:255',
                    'subcategory_id'=>'required|max:255',

                ];
                $error = Validator::make(request()->all(), $rules);
                if ($error->fails()) {
                    return $this->error($error->errors()->all(),400);
                }
                $name = request()->name;
                $price=\request()->price;
                $subcategory_id = request()->subcategory_id ;
                /*** if you want to implemnt subcategories with another subcategories ***/
                if(request()->subcategory_id)
                {
                    $subcategory_id=\request()->subcategory_id;
                    if($subcategory_id)
                        $subcategory = SubCategory::where('id', $subcategory_id)->first();
                    if ($subcategory) {
                        if($this->IfCanAddItem($subcategory))
                        {                            if (request()->discount)
                                $discount=request()->discount;
                            else
                                $discount=0;

                        item::create(['name' => $name,
                            "price" =>$price,
                               "subcategory_id"=> $subcategory_id,"discount"=>$discount]);}
else
    return $this->error("this subcategory contain subcategories not items");

                        return $this->success([], "created done",201);



                    } else {
                        return $this->error("subcategory not found",404);
                    }

                }
                else{    return $this->error("you should put subcategory");
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
    $item=item::where("id",$id)->first();    //
        if($item)
        {
         return $this->success(new itemResource($item),'done');
        }else
        {
            return $this->error('item not found',404);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {



        try {


            return DB::transaction(function() use ($id) {
$item=item::where('id',$id)->first();
                if($item)
                {


                $rules = [
                    'name' => 'required|string|max:255',
                    'price'=>'required|max:255',
                    'subcategory_id'=>'required|max:255',

                ];
                $error = Validator::make(request()->all(), $rules);
                if ($error->fails()) {
                    return $this->error($error->errors()->all(),400);
                }
                $name = request()->name;
                $price=\request()->price;
                $subcategory_id = request()->subcategory_id ;
                        $subcategory = SubCategory::where('id', $subcategory_id)->first();
                        if ($subcategory) {
                        if($this->IfCanAddItem($subcategory)) {
                            if (request()->discount)
                                $discount=request()->discount;
                            else
                                $discount=$item->discount;

                            $item->update(['name' => $name,
                                "price" => $price,
                                "subcategory_id" => $subcategory_id,'discount'=>$discount]);
                            return $this->success([], "update done");

                        } else
                            return $this->error("this subcategory contain subcategories not items");




                    } else {
                        return $this->error("subcategory not found",404);
                    }

                }
                else{    return $this->error("you should put subcategory");
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
                $item=item::where("id",$id)->first();
                if($item) {

                    $item->delete();
                    return $this->success($item, "delete done");
                }else
                {return $this->error("item not found");}

            });
        }
        catch (\Exception $e)
        {return $this->error($e->getMessage());}
    }



}
