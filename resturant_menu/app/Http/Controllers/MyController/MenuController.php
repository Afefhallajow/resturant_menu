<?php

namespace App\Http\Controllers\MyController;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ResponseFunction;
use App\Http\Controllers\ShowTheTree;
use App\Models\Category;
use App\Models\Menu;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Validator;

class MenuController extends Controller
{use ShowTheTree,ResponseFunction;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

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


            return DB::transaction(function(){
                $rules = [
                    'name'               => 'required|string|max:255',
                ];
                $error = Validator::make(request()->all(), $rules);
                if($error->fails()) {
                    return response()->json(['data' => $error->errors()->all()],400);
                }
                $name               = request()->name;
                if (request()->discount)
                    $discount=request()->discount;
                else
                    $discount=0;
                Menu::create(['name'=>$name,
                    'discount'=>$discount
                ]);
                return $this->success([],"created done",201);

            }
            );}
        catch (\Exception $e)
        {return response()->json(["message"=>$e->getMessage()]);}
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {


            $menu = Menu::where('id', $id)->first();
            return $this->ShowMenu($menu);
        }

      catch (\Exception $exception)
{return  $this->error($exception->getMessage());}


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
                $menu=Menu::where("id",$id)->first();
                if($menu) {

                    $rules = [
                        'name' => 'required|string|max:255',

                    ];
                    $error = Validator::make(request()->all(), $rules);
                    if ($error->fails()) {
                        return $this->error($error->errors()->all(),400);
                    }
                    $name = request()->name;
                    if (request()->discount)
                        $discount=request()->discount;
                    else
                        $discount=0;

                    $menu->update(['name'=>$name,"discount"=>$discount]);

                    return $this->success($menu, "update done");
                }else
                {return $this->error("menu not found",404);}
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
                $menu=Menu::where("id",$id)->first();
                if($menu) {
                    $menu->delete();
                    return $this->success($menu, "delete done");
                }else
                {return $this->error("category not found",404);}

            });
        }
        catch (\Exception $e)
        {return $this->error($e->getMessage());}
    }



}
