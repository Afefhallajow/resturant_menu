<?php

namespace App\Http\Controllers\MyController;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ResponseFunction;
use App\Http\Controllers\ShowTheTree;
use App\Models\Category;
use App\Models\Subcategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use PhpParser\Node\Expr\Array_;

class CategoriesController extends Controller
{
    use ResponseFunction, ShowTheTree;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $categories = Category::all();
            return $this->success($categories, 'done');
        } catch (\Exception $exception) {
            return $this->error($exception->getMessage());
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {


            return DB::transaction(function () {
                $rules = [
                    'name' => 'required|string|max:255',
                    "menu_id" => 'required|max:255'
                ];
                $error = Validator::make(request()->all(), $rules);
                if ($error->fails()) {
                    return $this->error($error->errors()->all(), 400);
                }
                $name = request()->name;
                if (request()->discount)
                    $discount = request()->discount;
                else
                    $discount = 0;

                Category::create(['name' => $name,
                    "discount" => $discount
                    , "menu_id" => \request()->menu_id
                ]);
                return $this->success([], "created done", 201);

            }
            );
        } catch (\Exception $e) {
            return response()->json(["message" => $e->getMessage()]);
        }
    }

    /**
     *
     * Display the specified resource.
     */
    public function show1(string $id)
    {

        try {
            return 'afef';
        }catch (\Exception $exception)
        {}
    }
    public function show(string $id)
    {

        try {
            return           DB::transaction(function ()use ($id){
                $Category=Category::where("id",$id)->first();
                if($Category)
       {$temp=['id'=>$Category->id,'name'=>$Category->name];
                    $temp['subcategories']=$this->generateTree($Category);

                return $this->success($temp,"done");

                }else
                    return $this->error("category not found",404);

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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
                return DB::transaction(function () use ($id){
                    $category=Category::where("id",$id)->first();

                    if($category) {

                        $rules = [
                            'name' => 'required|string|max:255',
                            "menu_id"=>'required|max:255'

                        ];
                        $error = Validator::make(request()->all(), $rules);
                        if ($error->fails()) {
                            return $this->error($error->errors()->all(),400);
                        }
                        $name = request()->name;
                        if (request()->discount)
                            $discount=request()->discount;
                        else
                            $discount=$category->discount;

                        $category->update(['name'=>$name," discount"=>$discount,"menu_id"=>\request()->menu_id]);

                        return $this->success($category, "update done");
                    }else
                    {return $this->error("category not found",404);}
                });
        }
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
                $category=Category::where("id",$id)->first();
                if($category) {
                    $category->delete();
                    return $this->success($category, "delete done");
                }else
                {return $this->error("category not found",404);}

            });
        }
        catch (\Exception $e)
        {return $this->error($e->getMessage());}
    }

}
