<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Models\Productgroup;
use Illuminate\Http\Request;

use App\Http\Requests\v1\productgroup\CreateProductgroupRequest;
use App\Http\Requests\v1\productgroup\UpdateProductgroupRequest;

use App\Http\Resources\v1\ProductgroupResource;

class ProductgroupController extends Controller
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

        $limit = 5;
        if($request->has('limit')){
            $limit = $request->get('limit');
        }

        
        $productgroups = Productgroup::orderBy('name', 'ASC')
            ->where($atr)
            ->paginate($limit);
        return ProductgroupResource::collection($productgroups);
        //return CategoryResource::collection(Category::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateProductgroupRequest $request)
    {
        $productgroup = Productgroup::create([
            'name' => $request->input('data.attributes.name'),
        ]);
        return (new ProductgroupResource($productgroup))
            ->response()
            ->header('Location', route('productgroups.show', ['productgroup' => $productgroup]));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Productgroup  $productgroup
     * @return \Illuminate\Http\Response
     */
    public function show(Productgroup $productgroup)
    {
        return new ProductgroupResource($productgroup);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Productgroup  $productgroup
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProductgroupRequest $request, Productgroup $productgroup)
    {
        $productgroup->update($request->input('data.attributes'));
        
        return new ProductgroupResource($productgroup);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Productgroup  $productgroup
     * @return \Illuminate\Http\Response
     */
    public function destroy(Productgroup $Productgroup)
    {
        //
    }
}
