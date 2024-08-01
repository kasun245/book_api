<?php

namespace App\Http\Controllers;
use App\Models\BookTypes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BookTypesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function getBookAllBookTypes()
    {
        $bookAllBookTypes = BookTypes::all();

        return response()->json([
            'responsecode' => '200',
            'message' => 'success',
            'data' => $bookAllBookTypes,
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function createNewBookType(Request $request)
    {
        $data = $request->all();
        $rules = [
            'booktypename' => 'required|unique:BookTypes,booktypename'
        ];
    
        $messages = [
            'booktypename.required' => 'Book type name is required.',
            'booktypename.unique' =>'This '  .$request->booktypename.  ' type name already exists.'
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return response()->json([
                'result' => 'fail',
                'message' => $validator->errors()->first(),
                'response_code' => '201'
            ], 422);
        }
        $bookType = BookTypes::create([
            'booktypeid'=>BookTypes::generateBookTypeId(),
            'booktypename'=>$request->booktypename
        ]);
        return response()->json(['result' => 'success', 'message' => 'New book type create success','response_code' => '200'], 200);

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
