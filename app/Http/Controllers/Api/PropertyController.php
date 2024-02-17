<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\PropertyStoreRequest;
use App\Http\Resources\PropertyResource;
use App\Models\Product;
use App\Models\Property;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PropertyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($product_id)
    {
        $product = Product::findOrFail($product_id);

        return PropertyResource::collection($product->properties); 
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PropertyStoreRequest $request, $product_id)
    {
        $product = Product::findOrFail($product_id);
        $product->properties()->create($request->validated());

        return PropertyResource::collection($product->properties);
    }

    /**
     * Display the specified resource.
     */
    public function show($product_id, $propertyId)
    {
        $product = Product::findOrFail($product_id);
        $property = $product->properties()->findOrFail($propertyId);
        return new PropertyResource($property);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PropertyStoreRequest $request, $product_id, $propertyId)
    {
        $product = Product::findOrFail($product_id);
        $property = $product->properties()->findOrFail($propertyId);
        $property->update($request->validated());

        return new PropertyResource($property);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($product_id, $propertyId)
    {
        $product = Product::findOrFail($product_id);
        $property = $product->properties()->findOrFail($propertyId);
        $property->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
