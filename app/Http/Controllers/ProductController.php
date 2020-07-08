<?php

namespace App\Http\Controllers;

use App\Model\Product;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\ProductRequest;
use App\Exceptions\ProductNotBelongsToUser;
use App\Http\Resources\Product\ProductResource;
use App\Http\Resources\Product\ProductCollection;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api')->except(['index', 'show']);
    }

    public function index()
    {
        return ProductCollection::collection(Product::paginate(10));
    }

    public function show(Product $product)
    {
        return new ProductResource($product);
    }

    public function store(ProductRequest $request)
    {
        $product = new Product();
        $product->name = $request->name;
        $product->detail = $request->detail;
        $product->stock = $request->stock;
        $product->price = $request->price;
        $product->discount = $request->discount;
        $product->save();

        return response()->json([
            'data' => new ProductResource($product),
        ]);
    }

    public function update(ProductRequest $request, $id)
    {
        $this->ProductUserCheck($request);

        $product = Product::findOrFail($id);
        $product->update($request->all());

        return response()->json([
            'data' => new ProductResource($product),
        ]);
    }

    public function destroy(Product $product)
    {
        $this->ProductUserCheck($product);

        $product->delete();

        return response()->json([
            'data' => new ProductResource($product),
        ]);
    }

    public function ProductUserCheck($product)
    {
        if (Auth::id() !== $product->id)
        {
            throw new ProductNotBelongsToUser;
        }
    }
}
