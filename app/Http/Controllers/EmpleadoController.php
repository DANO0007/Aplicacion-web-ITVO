<?php

namespace App\Http\Controllers;

use App\Models\Empleado;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EmpleadoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $datos['empleados']=Empleado::paginate(10);
        return view('empleado.index',$datos);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('empleado.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $campos=[
        'Nombre'=>'required|string|max:100',
        'ApellidoPaterno'=>'required|string|max:100',
        'ApellidoMaterno'=>'required|string|max:100',
        'Correo'=>'required|email',
        
        ];
        $mensaje=[
            'required'=>'El :attribute es requerido',
            

        ];
        $this->validate($request, $campos,$mensaje);

        $datosEmpleado = request()->except('_token');

        //Revisar esta parte......................................
        

        Empleado::insert($datosEmpleado);
        //return response()->json($datosEmpleado);
        return redirect('empleado')->with('mensaje','Empleado agregado con éxito');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Empleado  $empleado
     * @return \Illuminate\Http\Response
     */
    public function show(Empleado $empleado)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Empleado  $empleado
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $empleado=Empleado::findOrFail($id);
        return view('empleado.edit', compact('empleado'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Empleado  $empleado
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $campos=[
            'Nombre'=>'required|string|max:100',
            'ApellidoPaterno'=>'required|string|max:100',
            'ApellidoMaterno'=>'required|string|max:100',
            'Correo'=>'required|email',
            
            ];
            $mensaje=[
                'required'=>'El :attribute es requerido',
                
    
            ];
           
            $this->validate($request, $campos,$mensaje);


        //
        $datosEmpleado = request()->except(['_token','_method']);

        

        Empleado::where('id','=',$id)->update($datosEmpleado);
        $empleado=Empleado::findOrFail($id);
        return redirect('empleado')->with('mensaje','Empleado modificado');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Empleado  $empleado
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //Borrado con fotografia de carpeta Storage
        //$empleado=Empleado::findOrFail($id);

       // if(Storage::delete('public/'.$empleado->Foto)){
            Empleado::destroy($id);
        //}

        
        return redirect('empleado')->with('mensaje','Empleado borrado');
    }

    public function empleadojson(){
        $empleados = Empleado::all();
        return response()->json($empleados);
    }

    public function empleadoxml(){
        $empleados = Empleado::all();
     
      $prueba;
      $jsonstr = json_decode($empleados, true);

       foreach($empleados as $empleado){
        $prueba = $empleado;
      //array_push($prueba,(object)$empleado);
     // print_r($empleado);
      }
      
        return response()->xml($prueba);
    }

   /* public function empleadoxml(){
        $empleados = Empleado::all();
        $arregloempleados=[];
        foreach($empleados as $empleado){
            array_push($arregloempleados, $empleado);
        }
        
        return response()->xml($arregloempleados);

       
    }*/
}
