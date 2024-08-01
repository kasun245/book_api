<?php 

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\userregmodel;
use Illuminate\Support\Facades\Validator;

class userRegController extends controller
{
    public function usercreatecontroller(Request $request)
    {
        // $customer =  userregmodel::all();
        $validator = Validator::make($request->all(),[
            "userid"=>'required|string|max:220',
            "username"=>'required|string|max:220',
            "usermobileno"=>'required|string|max:220',
            "email"=>'required|string|max:220',
            "password"=>'required|string|max:220',
            "date"=>'required|string|max:220',
            "time"=>'required|string|max:220',
            "usertype"=>'required|string|max:220',
        ]);
        if ($validator ->fails()) {
            return response()->json(["status"=>422,"message"=>'Registation proccess fail. All Feilds are requered','response'=> "Fail"],
            422);
        }else{
            $customer = userregmodel::create([
                "userid" =>$request->userid,
                "username" =>$request-> username,
                "usermobileno" =>$request-> usermobileno,
                "email" =>$request->  email,
                "password" =>$request->password,
                "date" =>$request->date,
                "time" =>$request->time,
                "usertype" =>$request->usertype
            ]);
            if ($customer) {
                return response()-> json([
                    "Statues" => 200,
                    'response' => "Success",
                    "message" => "Registation success"
                ],200);
            } else {
                return response()-> json([
                    "Statues" => 500,
                    'response' => "fail",
                    // "data" => $customer,
                    "message" => "Customer create fail"
                ],500);
            }
            
        }
    }
}