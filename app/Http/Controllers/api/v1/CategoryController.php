<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

use App\Http\Requests\v1\categories\CreateCategoryRequest;
use App\Http\Requests\v1\categories\UpdateCategoryRequest;

use App\Http\Resources\v1\CategoryResource;

class CategoryController extends Controller
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

        if($request->has('filter_is_enable')){
            
            switch ($request->get('filter_is_enable')) {
                case 2:
                    array_push($atr, ['is_enable', 1]);
                    break;
                case 3:
                    array_push($atr, ['is_enable', 0]);
                    break;
            }

        }

        $limit = 5;
        if($request->has('limit')){
            $limit = $request->get('limit');
        }

        
        $categories = Category::orderBy('name', 'ASC')
            ->where($atr)
            ->paginate($limit);
        return CategoryResource::collection($categories);
        //return CategoryResource::collection(Category::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateCategoryRequest $request)
    {
        $category = Category::create([
            'name' => $request->input('data.attributes.name'),
            'is_enable' => $request->input('data.attributes.is_enable'),
        ]);
        return (new CategoryResource($category))
            ->response()
            ->header('Location', route('categories.show', ['category' => $category]));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        return new CategoryResource($category);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCategoryRequest $request, Category $category)
    {
        $category->update($request->input('data.attributes'));
        
        return new CategoryResource($category);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        //
    }
}
