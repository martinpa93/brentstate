<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\UserController;

use JWTAuth;
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
        return response()->json($properties, 200);
    }

    public function indexBystatus()
    {   
        $user = JWTAuth::parseToken()->authenticate();
        $contracts = $user->contracts->where('status', '=', true);
        $properties = $user->properties;
        $properties = $properties->map(function ($item,$key) use ($contracts) {
            $a = false;
            //dd($item->cref);
             
            $contracts->each(function ($prop) use ($item, $key, &$a) {
                if ( $item->cref === $prop->property_id) {
                    $item->status = true;
                    $a=true;
                    return false;
                } 
            });
            if ($a === false) $item->status = false;
            return $item;
        });
        return response()->json($properties , 200);
    }

    /**
     * Store a newly creat
     * ed resource in storage.
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
            'type' => 'required|bail|in:Vivienda,Local comercial,Garaje',
            'm2' => 'required|bail|numeric|min:1|max:5000',
            'nroom' => 'required|numeric|min:1|max:20',
            'nbath' => 'required|numeric|min:1|max:20'
            ]); 
            if($validator->fails()){
                return response()->json($validator->errors()->toJson(), 400);
            }
            
        $user_id = JWTAuth::parseToken()->authenticate();
        $property = Property::firstOrCreate([
            'cref' => $request->get('cref'),
            'user_id' => $user_id->id,
            'address' => $request->get('address'),
            'population' => $request->get('population'),
            'province' => $request->get('province'),
            'cp' => $request->get('cp'),
            'type' => $request->get('type'),
            'm2' => $request->get('m2'),
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
        $user = JWTAuth::parseToken()->authenticate();
        $property = $user->properties()->where('cref', $id)->get();
        if($property->isEmpty()){
            return response()->json('',204);
        }
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
        $validator = Validator::make($request->all(), [
        
            'address' => 'required|bail|string|max:255',
            'population' => 'required|bail|string',
            'province' => 'required|bail|string',
            'cp' => 'required|bail|numeric|min:1000|max:51000',
            'type' => 'required|bail|in:Vivienda,Local comercial,Garaje',
            'm2' => 'required|bail|numeric|min:1|max:5000',
            'nroom' => 'required|numeric|min:1|max:20',
            'nbath' => 'required|numeric|min:1|max:20'
            ]); 
        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }


        $user = JWTAuth::parseToken()->authenticate();
        $property=Property::where('cref',$id)->where('user_id', $user->id);
        if(!$property->exists())
            return response()->json('', 204);
        else{
            $property->update([
                'user_id' => $user->id,
                'address' => $request->get('address'),
                'population' => $request->get('population'),
                'province' => $request->get('province'),
                'cp' => $request->get('cp'),
                'type' => $request->get('type'),
                'm2' => $request->get('m2'),
                'nroom' => $request->get('nroom'),
                'nbath' => $request->get('nbath'),
            ]);

            return response()->json($request, 200);
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
        $user = JWTAuth::parseToken()->authenticate();
        $property = $user->properties()->where('cref', $id);
        if ($property->exists()){
            $property->delete();
            return response()->json('The register '.$id.' have been deleted succesfully', 205);
        }
        return response()->json('The register '.$id.' have not been found', 400);
    }
}
