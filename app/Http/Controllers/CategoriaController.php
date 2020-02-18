<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\Doctrine\ProductoDoctrine;
use Exception;
use Illuminate\Support\Facades\Redirect;

class CategoriaController extends Controller
{
    function index(Request $r){
        $ps=new ProductoDoctrine();
        return view('crud.categorias',[
            'list' => $ps->listarCategorias(),
            'get' => $r->id ? $ps->obtenerCategoria($r->id) : null
        ]);
    }

    function save(Request $r){
        $ps=new ProductoDoctrine();
        if ($r->id) { 
            $ps->modificarCategoria($r->id, $r->nombre, $r->descripcion);
        }else{
            $ps->crearCategoria($r->nombre, $r->descripcion);
        }
        return Redirect::route('categorias');
    }

    function remove(Request $r){        
        $ps=new ProductoDoctrine();
        try {
            $ps->borrarCategoria($r->id);
        } catch (Exception $e) {
            return Redirect::back()->withErrors([$e->getMessage()]);
        }
        return Redirect::route('categorias');
    }
}
