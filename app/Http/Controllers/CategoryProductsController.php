<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CategoryProductsController extends Controller
{
    public  function showProducts($title,$id){
        $products=$this->marketService->getCategoryProducts($id);

        return view('categories.products.show')->with(
            [
                'products'=>$products,
            ]);

    }
}
