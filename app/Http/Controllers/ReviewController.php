<?php

namespace App\Http\Controllers;

use App\Model\Review;
use App\Model\Product;
use App\Http\Requests\ReviewRequest;
use App\Http\Resources\Review\ReviewResource;
use Symfony\Component\HttpFoundation\Response;

class ReviewController extends Controller
{

    public function index(Product $product)
    {
        return ReviewResource::collection($product->reviews);
    }

    public function store(ReviewRequest $request, Product $product)
    {
        $review = new Review($request->all());
        $product->reviews()->save($review);

        return response()->json([
            'data' => new ReviewResource($review)
        ], Response::HTTP_CREATED);
    }

}
