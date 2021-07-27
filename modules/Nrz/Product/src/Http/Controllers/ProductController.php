<?php

namespace Nrz\Product\Http\Controllers;

use App\Http\Controllers\Controller;
use Nrz\Product\Http\Requests\ProductRequest;
use Nrz\Product\Http\Resources\ProductResourceCollection;
use Nrz\Product\Models\Attribute;
use Nrz\Product\Models\AttributeValue;
use Nrz\Product\Models\Product;
use Nrz\Product\Repo\ProductRepo;

class ProductController extends Controller
{

    public function index(ProductRepo $productRepo)
    {
        $products = Product::query()
            ->latest()
            ->get()
            ->all();

        return new ProductResourceCollection($products);
    }


    public function store(ProductRequest $request, ProductRepo $productRepo)
    {

        $product = $productRepo->store($request->name, $request->price);

        $this->fetchOptions($request->payload, $product, $productRepo);

        return response([
            "data" => 'محصول مورد نظر با موفقیت ایجاد شد'
        ], 200);

    }

    public function fetchOptions($payload, $product, $productRepo)
    {
        $attributes = collect($payload);
        $attributes->each(function ($item) use ($product, $productRepo) {
            if (is_null($item['name']) || is_null($item['value'])) return;
            $attr = $productRepo->findOrCreateAttributes($item['name']);

            $attr_value = $productRepo->findOrCreateValue($item['value'],$attr);

            $product->attributes()->attach($attr->id, [
                'value_id' => $attr_value->id
            ]);
        });

    }


}
