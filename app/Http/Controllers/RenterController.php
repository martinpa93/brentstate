<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use JWTAuth;
use App\User;
use App\Renter;

class RenterController extends Controller
{
    public function index()
    {   
        $user = JWTAuth::parseToken()->authenticate();
        $renters = $user->renters;
        return response()->json($renters, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        $validator = Validator::make($request->all(), [
            'dni' => 'required|bail|string|size:9|unique:renters',
            'name' => 'required|bail|string|min:2|max:15',
            'surname' => 'required|bail|string|min:2|max:20',
            'dbirth' => 'required|bail|date',
            'address' => 'required|bail|string|max:255',
            'population' => 'required|bail|string',
            'phone' => 'required|numeric|digits:9',
            'iban' => 'required|string|size:24',
            'job' => 'string|min:2|max:20',
            'salary' => 'numeric|between:100.99,10000.99'
            ]); 
            if($validator->fails()){
                return response()->json($validator->errors()->toJson(), 400);
            }
            
        $user_id = JWTAuth::parseToken()->authenticate();
        $pipe = date("Y-m-d H:i:s", strtotime($request->get('dbirth')));
        $renter = Renter::create([
            'dni' => $request->get('dni'),
            'user_id' => $user_id->id,
            'name' => $request->get('name'),
            'surname' => $request->get('surname'),
            'dbirth' => $pipe,
            'address' => $request->get('address'),
            'population' => $request->get('population'),
            'phone' => $request->get('phone'),
            'iban' => $request->get('iban'),
            'job' => $request->get('job'),
            'salary' => $request->get('salary')
        ]);
        $renter->save();
        
        return response()->json($request,201);
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
        $user = JWTAuth::parseToken()->authenticate();
        $renter = $user->renters()->where('dni', $id)->get();
        if($renter->isEmpty()){
            return response()->json('',204);
        }
        return response()->json($renter, 200);
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
        $validator = Validator::make($request->all(), [
            'name' => 'required|bail|string|min:2|max:15',
            'surname' => 'required|bail|string|min:2|max:20',
            'dbirth' => 'required|bail|date',
            'address' => 'required|bail|string|max:255',
            'population' => 'required|bail|string',
            'phone' => 'required|numeric|digits:9',
            'iban' => 'required|string|size:24',
            'job' => 'string|min:2|max:20',
            'salary' => 'numeric|between:100.99,10000.99'
            ]); 
        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }

        $user_id = JWTAuth::parseToken()->authenticate();
        $renter=Renter::where('dni',$id);
        $pipe = date("Y-m-d H:i:s", strtotime($request->get('dbirth')));

        if(!$renter->exists())
            return response()->json('', 204);
        else{
            $renter->update([
                'user_id' => $user_id->id,
                'name' => $request->get('name'),
                'surname' => $request->get('surname'),
                'dbirth' => $pipe,
                'address' => $request->get('address'),
                'population' => $request->get('population'),
                'phone' => $request->get('phone'),
                'iban' => $request->get('iban'),
                'job' => $request->get('job'),
                'salary' => $request->get('salary')
            ]);
            return response()->json('Updated succesfully', 200);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if($user = JWTAuth::parseToken()->authenticate()){
            $renter = $user->renters()->where('dni', $id);
            if ($renter->exists()){
                $renter->delete();
                return response()->json('Deleted succesfully', 205);
            }
            else return response()->json('This register dont exist', 400);
        }
        else return response()->json('Deleted succesfully', 205);
    }
}
