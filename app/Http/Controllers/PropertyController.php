<?php

namespace App\Http\Controllers;

use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\Http\Requests\PropertiesStoreRequest;
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
    public function store(PropertiesStoreRequest $request)
    {
        
        $property = Property::create([
            'cref' => $request->get('cref'),
            'user_id' => $request->get('user_id'),
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
        
        return response()->json($property);
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
        
        return response()->json($property);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PropertiesStoreRequest $request, $id)
    {
        /* dd($request->all()); */
        $property = Property::findOrFail($id)->first()->fill($request->all())->save();    
        return response()->json($property);
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
        return response()->json($property);
    }
}
