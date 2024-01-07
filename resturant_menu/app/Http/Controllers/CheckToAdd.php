<?php


namespace App\Http\Controllers;


use function PHPUnit\Framework\isEmpty;

trait CheckToAdd
{
    /** to check if we can add item to subcategory */
public function IfCanAddItem($opject)
{
if(sizeof($opject->subcategories)>0)
    return false;
else
    return true;

}
    /** to check if we can add subcategory to subcategory */

public function IfCanAddsubcategory($opject)
    {
        if(sizeof($opject->items)>0) {
            return false;
        }else {

            return true;
}
    }
/** to check the level of subcategory we have */
public function checkTheLevel($parent,$opject)
{$parentnumber=0;

    $parentnumber+=$this->calculateParents($parent);
    $sonhieght=$this->calculateHeight($opject);

    $level=$parentnumber+$sonhieght;

    return $level <=4 ?true:false;
}

/** to calculate the thr number of parents to node */
    public function calculateParents($firstparent)
    {

    $i=1;
    while ($firstparent->Subcategory)
    {
        $i=$i+1;
        $firstparent=$firstparent->Subcategory;
    }
    return $i;
    }
    /** to calculate the thr number of sons to node */
public function calculateHeight($subcategory)
{$subcategories=$subcategory->subcategories;
    if(empty($subcategories))
        return 0;
    $maxchildheight=0;
    foreach ($subcategories as $child){
        $childHeight=$this->calculateHeight($child);
    $maxchildheight=max($maxchildheight,$childHeight);
    }
return 1+$maxchildheight;
}



}
