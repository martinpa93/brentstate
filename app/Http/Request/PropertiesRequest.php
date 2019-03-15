<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;


class PropertiesRequest extends FormRequest
{

    
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'cref' => 'required|bail|string|size:20|unique:properties',
            'user_id' => 'required|exists:users,id',
            'address' => 'required|bail|string|max:255',
            'population' => 'required|bail|string',
            'province' => 'required|bail|string',
            'cp' => 'required|bail|numeric|min:1000|max:51000',
            'type' => 'in:Vivienda,Local comercial,Garaje',
            'm2' => 'required|bail|numeric|min:1|max:5000',
            'ac' => 'boolean',
            'nroom' => 'numeric|min:1|max:20',
            'nbath' => 'numeric|min:1|max:20'
        ];
    }

    public function messages()
    {
        return [
            'cref.required' => 'La referencia catastral es requerida',
            'address.required' => 'La dirección es requerida',
            'population.required' => 'La población es requerida',
            'province.required' => 'La provincia es requerida',
            'cp.required' => 'El codigo postal provincia es requerido',
            'type.required' => 'El tipo de inmueble es requerido',
            'm2.required' => 'Los m2 son requeridos',
            'cref.string' => 'La referencia catastral no es valida',
            'address.string' => 'La dirección no es valida',
            'population.string' => 'La población no es valida',
            'province.string' => 'La provincia no es valida',
            'cp.numeric' => 'El código postal no es valido',
            'type.in' => 'El tipo de inmueble no es valido',
            'm2.string' => 'Los m2 no son validos'
        ];
    } 
}
