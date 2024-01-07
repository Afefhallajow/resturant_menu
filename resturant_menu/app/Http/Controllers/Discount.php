<?php


namespace App\Http\Controllers;


use App\Models\item;

trait Discount
{
/** to calculate the discount for every item if it have discount we use it else we get first parent discount and use it */
    public function itemdiscount($item)
    {
        if ($item->discount == 0) {
            $subcategory = item::where('id', $item->id)->first()->subcategory;
            while (true)
                if ($subcategory->discount != 0) {
                    $item->discount = $subcategory->discount;
                    break;
                } else {
                    if ($subcategory->Subcategory) {
                        $subcategory = $subcategory->Subcategory;
                    if($subcategory->discount ==0)
                    {while ($subcategory->Subcategory) {
                        $subcategory = $subcategory->Subcategory;
                        if($subcategory->discount !=0)
                        {
                            $item->discount = $subcategory->discount;
break;
                        }
                    }
                    }
                    else{
                        $item->discount = $subcategory->discount;
break;
                    }
                    }
                    elseif ($subcategory->Category) {
                        $subcategory = $subcategory->Category;
                        if ($subcategory->discount != 0) {
                            $item->discount = $subcategory->discount;
                            break;

                        } else {
                            $subcategory = $subcategory->menu;
                            if ($subcategory->discount != 0) {
                                $item->discount = $subcategory->discount;
                                break;

                            }
                            else {
                                $item->discount = 0;
                            break;
                            }
                        }
                    }
                }


        }
return $item->discount;
    }

}
