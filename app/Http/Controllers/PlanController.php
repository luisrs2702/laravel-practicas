<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use Illuminate\Http\Request;

class PlanController extends Controller
{
    public function index(){
        $planes=Plan::orderBy('nombre_plan')->get();
        //return $planes;
        //$planes=Plan::with('miembro:id,nombre')->get();
        //$planes=Plan::with('miembro:id,nombre')->get(['id','status','membresia_id','miembro_id']);
       // $ventas=Venta::with('productos','user')->get(['id','created_at AS fecha_venta','total','user_id']);
       
        return $planes;
    }

    public function store(Request $request){
        /** @var \App\Models\User $user */
        $user = auth()->user();
        if (!$user->hasRole('recepcionista')) {
            return response()->json([
                'message' => 'No tienes permisos para realizar esta acción.'
            ], 403);
        }
        $request->validate([
            'nombre_plan'=>'required|string|max:100|min:4',
            'descripcion'=>'required|string|max:100|min:3',
            'frecuencia_pago'=>'required|string|in:semanal,mensual,anual',
            'costo'=>'required|numeric|digits_between:1,5',
            'duracion_dias'=>'required|integer|digits_between:1,4',
        ]);
        $plan=Plan::create($request->all());
        return $plan;
    }    
}
