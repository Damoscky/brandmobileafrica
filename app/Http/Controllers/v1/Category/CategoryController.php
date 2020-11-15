<?php

namespace App\Http\Controllers\v1\Category;

use Validator;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $categories = Category::Where('is_active', 1)->get();
            if(!$categories){
                return response()->json([
                    'error' => true,
                    'message' => 'Categories not found',
                    'data' => null
                ]);
            }
            return response()->json([
                'error' => false,
                'message' => null,
                'data' => $categories
            ]);
        } catch (\Throwable $error) {
            return response()->json([
                'error' => true,
                'message' => $error->getMessage(),
                'data' => null
            ]);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $credentials = $request->only('name');
        $rules = [
            'name' => 'required|min:2',
        ];
        $validateCategoryName = Validator::make($credentials, $rules);
        if($validateCategoryName->fails()){
            return response()->json([
                'error' => true,
                'message' => 'Category name is required',
                'data' => null
            ]);
        }
        // DB::beginTransaction();
        try {
            $category = Category::create([
                'name' => $request->name
            ]);
            if(!$category){
                return response()->json([
                    'error' => true,
                    'message' => 'Category was not saved, Error occured.',
                    'data' => null
                ]);
            }
            // DB::commit();
            return response()->json([
                'error' => false,
                'message' => 'Category saved successfully',
                'data' => $category
            ], 201);
            // DB::rollBack();
        } catch (\Throwable $th) {
            return response()->json([
                'error' => true,
                'message' => $error->getMessage(),
                'data' => null
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
