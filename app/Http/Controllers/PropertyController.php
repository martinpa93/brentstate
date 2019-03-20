<?php

namespace App\Http\Controllers;

use JWTAuth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\UserController;

use App\User;
use App\Property;

class PropertyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    
    public function index()
    {   
        $user = JWTAuth::parseToken()->authenticate();
        $properties = $user->properties;
        return response()->json($properties);
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
            'cref' => 'required|bail|string|size:20|unique:properties',
            'address' => 'required|bail|string|max:255',
            'population' => 'required|bail|string',
            'province' => 'required|bail|string',
            'cp' => 'required|bail|numeric|min:1000|max:51000',
            'type' => 'in:Vivienda,Local comercial,Garaje',
            'm2' => 'required|bail|numeric|min:1|max:5000',
            'ac' => 'boolean',
            'nroom' => 'numeric|min:1|max:20',
            'nbath' => 'numeric|min:1|max:20'
            ]); 
            if($validator->fails()){
                return response()->json($validator->errors()->toJson(), 400);
            }
            
        $user_id = JWTAuth::parseToken()->authenticate();
        $property = Property::create([
            'cref' => $request->get('cref'),
            'user_id' => $user_id->id,
            'address' => $request->get('address'),
            'population' => $request->get('population'),
            'province' => $request->get('province'),
            'cp' => $request->get('cp'),
            'type' => $request->get('type'),
            'm2' => $request->get('m2'),
            'ac' => $request->get('ac'),
            'nroom' => $request->get('nroom'),
            'nbath' => $request->get('nbath'),
        ]);
    
        $property->save();
        
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
        $property = $user->properties()->where('cref', $id)->get();
        
        return response()->json($property, 200);
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
        $property = Property::findOrFail($id)->first()->fill($request->all())->save();    
        return response()->json($property, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = JWTAuth::parseToken()->authenticate();
        $property = $user->properties()->where('cref', $id)->delete();
        return response()->json($property, 200);
    }
}
