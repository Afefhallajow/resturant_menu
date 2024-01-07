<?php


namespace App\Http\Controllers;


use App\Models\Category;
use App\Models\item;

trait ShowTheTree
{use Discount;

/** we generate the tree for each categories here */
    function generateTree($category)
    {
        $tree=[];
        if($category instanceof Category)
        {   foreach ($category->subcategories as $key=> $sub)
            if( !sizeof($sub->items) )
        {
            $tree[$key]=[
                'id'=>$sub->id
            ,'name'=>$sub->name,
            'categories'=>[]
            ];


       $count=sizeof($sub->subcategories);
        for ($i=0;$i<$count;$i++)
        {
            $tree[$key]['categories'][]= $this->generateTree($sub->subcategories[$i]);
        }
        }
        else{
$items=[];
    foreach ($sub->items as $key=>$item)
    {
$dicount=$this->itemdiscount($item);
$precentage=$item->price *($item->discount/100);
$price_after_discount=$item->price-$precentage;
$items[$key]=['id'=>$item->id,
            'name'=>$item->name,
            'discount'=>$dicount,
            "price"=>$item->price,
    'price_after_discount'=>$price_after_discount
        ];
    }
            $tree[$key]=[
                'id'=>$sub->id
                ,'name'=>$sub->name,
                'items'=>$items
            ];



        }

    }
        /** when we use backtracking for childern   **/
        else{
            if(!sizeof($category->items) )
            {
                $tree=[
                    'id'=>$category->id
                    ,'name'=>$category->name,
                    'categories'=>[]
                ];


                $count=sizeof($category->subcategories);
                for ($i=0;$i<$count;$i++)
                {
                    $tree['categories'][]=$this->generateTree($category->subcategories[$i]);
                }
            }
            else{

                $items=[];
                foreach ($category->items as $key=>$item)
                {
                    $dicount=$this->itemdiscount($item);
                    $precentage=$item->price *($item->discount/100);
                    $price_after_discount=$item->price-$precentage;

                    $items[$key]= ['id'=>$item->id,
                        'name'=>$item->name,
                        'discount'=>$dicount,
                        "price"=>$item->price,
                        'price_after_discount'=>$price_after_discount
                    ];
                }

                $tree=[
                    'id'=>$category->id
                    ,'name'=>$category->name,
                    'items'=>$items
                ];



            }


        }
        return $tree;
    }

/** we generate the tree for each menu here */
    function ShowMenu($menu)
    {$arr=[];
        foreach ($menu->categories as$key=> $category)
        {$arr[$key]=['id'=>$category->id,
            "name"=>$category->name,
            ];
            $arr[$key]['subcategories']=$this->generateTree($category);
        }
    return $arr;
    }


}
