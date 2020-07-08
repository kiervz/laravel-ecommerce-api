<?php

namespace App\Http\Controllers;

use App\Http\Resources\Product\ProductCollection;
use App\Http\Resources\Product\ProductResource;
use App\Model\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        return ProductCollection::collection(Product::paginate(10));
    }

    public function show(Product $product)
    {
        return new ProductResource($product);
    }
}
