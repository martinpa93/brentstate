<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

use JWTAuth;
use App\User;
use App\Property;
use App\Renter;
use App\Contract;
use Carbon\Carbon;

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
        $contracts->map(function($item, $key) use ($contracts) {
            $properties = DB::table('properties')->where('cref','=',$item->property_id)->select('cref','address')->get();
            $renters = DB::table('renters')->where('dni','=',$item->renter_id)->select('dni','name','surname')->get();
            $contracts[$key]->address = $properties[0]->address;
            $contracts[$key]->name = $renters[0]->name;
            $contracts[$key]->surname = $renters[0]->surname;
        });
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

        $user = JWTAuth::parseToken()->authenticate();
        $contracts = $user->contracts->where('property_id', $request->get('property_id'));
        $overlap = false;
        $contracts->each(function ($item, $key)  use ($request, &$overlap) {
            $pipe = date("Y-m-d H:i:s", strtotime($request->get('dstart')));
            $pipe2 = date("Y-m-d H:i:s", strtotime($request->get('dend')));
            if(!(($item->dstart <= $pipe && $item->dstart <= $pipe2 && $item->dend <= $pipe && $item->dend <= $pipe2) ||
              ($pipe <= $item->dstart && $pipe <= $item->dend && $pipe2 <= $item->dstart && $pipe2 <= $item->dend)))
                $overlap = true;
        });
        if ($overlap) return response()->json('El rango de fechas es incorrecto', 400);

        $pipe = date("Y-m-d H:i:s", strtotime($request->get('dstart')));
        $pipe2 = date("Y-m-d H:i:s", strtotime($request->get('dend')));
        $today=Carbon::today();
        $boolean=false;
        
        if($today >= $pipe && $today < $pipe2 ){ 
            $boolean=true;    
        }
        $contract = Contract::firstOrCreate([
            'user_id' => $user->id,
            'property_id' => $request->get('property_id'),
            'renter_id' => $request->get('renter_id'),
            'dstart' => $pipe,
            'dend' => $pipe2,
            'status'=> $boolean
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
        $contracts = $user->contracts->where('property_id', $request->get('property_id'));
        $overlap = false;
        $contracts->each(function ($item, $key)  use ($id, $request, &$overlap) {
            if((int)$id === $item->id) {
                return true;
            }
            $pipe = date("Y-m-d H:i:s", strtotime($request->get('dstart')));
            $pipe2 = date("Y-m-d H:i:s", strtotime($request->get('dend')));
            if(!(($item->dstart <= $pipe && $item->dstart <= $pipe2 && $item->dend <= $pipe && $item->dend <= $pipe2) ||
            ($pipe <= $item->dstart && $pipe <= $item->dend && $pipe2 <= $item->dstart && $pipe2 <= $item->dend)))
                $overlap = true;
        });
        if($overlap) return response()->json('El rango de fechas es incorrecto', 400);

        $pipe = date("Y-m-d H:i:s", strtotime($request->get('dstart')));
        $pipe2 = date("Y-m-d H:i:s", strtotime($request->get('dend')));
        $today=Carbon::today();
        $contract=$user->contracts()->where('id', $id)->get();
        $boolean=false;

        if($today >= $pipe && $today < $pipe2 ){
            $boolean=true;
        }
        if(!$contract->isEmpty()){
            $contract=Contract::where('id',$id);
            $contract->update([
                'user_id' => $user->id,
                'property_id' => $request->get('property_id'),
                'renter_id' => $request->get('renter_id'),
                'dstart' => $pipe,
                'dend' => $pipe2,
                'status'=> $boolean
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