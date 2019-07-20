<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\UserController;

use JWTAuth;
use App\User;
use App\Contract;

class ContractController extends Controller
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
        
        $validator = Validator::make($request->all(), [
            'property_id' => 'required|string|size:20|exists:properties,cref',
            'renter_id' => 'required|bail|string|size:9|exists:renters,dni',
            'dstart' => 'required|bail|date',
            'dend' => 'required|bail|date',
            ]); 
        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }
            
        $user_id = JWTAuth::parseToken()->authenticate();
        $pipe = date("Y-m-d H:i:s", strtotime($request->get('dstart')));
        $pipe2 = date("Y-m-d H:i:s", strtotime($request->get('dend')));
        $contract = Contract::firstOrCreate([
            'user_id' => $user_id->id,
            'property_id' => $request->get('property_id'),
            'renter_id' => $request->get('renter_id'),
            'dstart' => $pipe,
            'dend' => $pipe2
        ]);
        
        return response()->json($contract,201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) 
    /* id es el registro, solo muestra contratos del usuario
    que envía el token  */
    {
        $user = JWTAuth::parseToken()->authenticate();
        $contract = $user->contracts()->where('id', $id)->get();
        if($contract->isEmpty()){
            return response()->json('',204);
        }
        return response()->json($contract, 200);
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
            'property_id' => 'required|string|size:20|exists:properties,cref',
            'renter_id' => 'required|bail|string|size:9|exists:renters,dni',
            'dstart' => 'required|bail|date',
            'dend' => 'required|bail|date',
            ]); 
        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }
        $user= JWTAuth::parseToken()->authenticate();
        $pipe = date("Y-m-d H:i:s", strtotime($request->get('dstart')));
        $pipe2 = date("Y-m-d H:i:s", strtotime($request->get('dend')));
        $contract=$user->contracts()->where('id', $id)->get();
        if(!$contract->isEmpty()){
            $contract=Contract::where('id',$id);
            $contract->update([
                'user_id' => $user->id,
                'property_id' => $request->get('property_id'),
                'renter_id' => $request->get('renter_id'),
                'dstart' => $pipe,
                'dend' => $pipe2
                ]);
            $contract=Contract::where('id',$id)->get();
            return response()->json($contract, 200);
        }
        return response()->json('', 204);
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
            $contract = $user->contracts()->where('id', $id);
            if ($contract->exists()){
                $contract->delete();
                return response()->json('The register '.$id.' have been deleted succesfully', 205);
            }
            else return response()->json('The register '.$id.' have not been found', 400);
    }
}