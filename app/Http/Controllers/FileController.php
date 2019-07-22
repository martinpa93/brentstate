<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\UserController;

use JWTAuth;
use App\User;

class FileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    
    public function index()
    {   
        $user = JWTAuth::parseToken()->authenticate();
        $contracts = $user->contracts;
        return response()->json($contracts, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $file = $request->file('file');
        $user_id = JWTAuth::parseToken()->authenticate();
        $validator = Validator::make($request->all(), [
            'file' => 'required|file|max:1024'
            ]); 
        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }
            
        $fileName = $user_id->id.$file->getClientOriginalName.$file->getClientOriginalExtension();
        dd($fileName);
        Storage::disk('local')->putFileAs(
            'renters/'.$filename,
            $file,
            $filename
          );
    }

    
    public function destroy($id)
    {
        $user = JWTAuth::parseToken()->authenticate();
            $contract = $user->contracts()->where('id', $id);
            if ($contract->exists()){
                $contract->delete();
                return response()->json('The register '.$id.' have been deleted succesfully', 205);
            }
            else return response()->json('The register '.$id.' have not been found', 400);
    }
}