<?php

namespace App\Http\Controllers;
use App\Models\Bookcategory;
use App\Models\BookTypes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BookcategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function getCategoryAndTypes()
    {
        $bookCategories = BookCategory::all();
        $bookAllBookTypes = BookTypes::all();
        return response()->json([
            'responsecode' => '200',
            'message' => 'success',
            'data' =>  [
                'bookCategories' => $bookCategories,
                'bookAllBookTypes' => $bookAllBookTypes
            ]
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function createNewCategory(Request $request)
    {
        $data = $request->all();
        $rules = [
            'categoryname' => 'required|unique:bookcategories,categoryname'
        ];
    
        $messages = [
            'categoryname.required' => 'Book category name is required.',
            'categoryname.unique' =>'This '  .$request->categoryname.  ' category name already exists.'
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return response()->json([
                'result' => 'fail',
                'message' => $validator->errors()->first(),
                'response_code' => '201'
            ], 422);
        }
        $categories = Bookcategory::create([
            'categoryid'=>Bookcategory::generateCategoryId(),
            'categoryname'=>$request->categoryname
        ]);
        return response()->json(['result' => 'success', 'message' => 'New book category create success','response_code' => '200'], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
