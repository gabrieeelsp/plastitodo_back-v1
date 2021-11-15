<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

use App\Http\Requests\v1\products\CreateProductRequest;
use App\Http\Requests\v1\products\UpdateProductRequest;
use App\Http\Requests\v1\products\UpdateProductSetCategoryRequest;

use App\Http\Resources\v1\ProductResource;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $searchText = trim($request->get('q'));
        $val = explode(' ', $searchText );
        $atr = [];
        foreach ($val as $q) {
            array_push($atr, ['name', 'LIKE', '%'.strtolower($q).'%'] );
        };

        //filtering is_enable
        if ( $request->has('filter_is_enable')) {
            $filter_is_enable = $request->get('filter_is_enable');
            if ( $filter_is_enable == 2 ) { array_push($atr, ['is_enable', true]); }
            if ( $filter_is_enable == 3 ) { array_push($atr, ['is_enable', false]); }
        }

        $limit = 5;
        if($request->has('limit')){
            $limit = $request->get('limit');
        }

        
        $products = Product::orderBy('name', 'ASC')
            ->where($atr)
            ->paginate($limit);
        return ProductResource::collection($products);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateProductRequest $request)
    {
        $data = $request->get('data');
        $category_id = $data['relationships']["category"]["data"]["id"];

        $product = Product::create($request->input('data.attributes'));

        $product->category()->associate(Category::find($category_id));
        $product->save();
     
        return (new ProductResource($product))
            ->response()
            ->header('Location', route('products.show', ['product' => $product]));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Product $product)
    {
        return new ProductResource($product);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        
        $product->update($request->input('data.attributes'));
        
        return new ProductResource($product);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        //
    }

    public function set_category(UpdateProductSetCategoryRequest $request, $product_id) 
    {
        $data = $request->get('data');
        $category_id = $data['relationships']["category"]['data']['id'];
        $product = Product::findOrFail($product_id);

        $product->category()->associate($category_id);
        $product->save();
        return new ProductResource($product);
    }
}
