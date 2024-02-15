<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProductsController extends Controller
{
    public function showProduct($title,$id){
        $product=$this->marketService->getProduct($id);

        return view('products.show')->with([
           'product'=>$product,
        ]);
    }
}
