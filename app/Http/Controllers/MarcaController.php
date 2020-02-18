<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Entities\Marca;
use App\Services\Doctrine\ProductoDoctrine;
use Exception;
use Illuminate\Support\Facades\Redirect;
use LaravelDoctrine\ORM\Facades\EntityManager;

class MarcaController extends Controller
{
    function index(Request $r){
        $ps=new ProductoDoctrine();
        return view('crud.marcas',[
            'list' => $ps->listarMarcas(),
            'get' => $r->id ? $ps->obtenerMarca($r->id) : null
        ]);
    }

    function save(Request $r){
        $ps=new ProductoDoctrine();
        if ($r->id) { 
            $ps->modificarMarca($r->id, $r->nombre, $r->descripcion);
        }else{
            $ps->crearMarca($r->nombre, $r->descripcion);
        }
        return Redirect::route('marcas');
    }

    function remove(Request $r){
        $ps=new ProductoDoctrine();
        try {
            $ps->borrarMarca($r->id);
        } catch (Exception $e) {
            return Redirect::back()->withErrors([$e->getMessage()]);
        }
        return Redirect::route('marcas');
    }
}
